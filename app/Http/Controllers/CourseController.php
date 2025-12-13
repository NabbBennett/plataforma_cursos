<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\WeekDay;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $userId = auth()->id();

        $purchase = Purchase::where('user_id', $userId)
            ->where('course_id', $id)
            ->first();

        if (!$purchase) {
            abort(403, 'No tienes acceso a este curso.');
        }

        $course = Course::with([
            'weeks' => function($q) {
                $q->orderBy('number');
            },
            'weeks.weekDays',
            'weeks.exam',
            'evaluationBlocks' => function($q) {
                $q->with('exams');
            }
        ])->findOrFail($id);

        $weeks = $course->weeks()->with('exams')->get();
        $exams = collect();
        foreach ($weeks as $week) {
            $exams = $exams->merge($week->exams);
        }

        $blocks = $course->evaluationBlocks()->with('exams')->get();
        foreach ($blocks as $block) {
            $exams = $exams->merge($block->exams);
        }
        $examProgress = app(ExamStudentController::class)->getExamProgress($id);
        $bloquesEvaluacion = $course->evaluationBlocks()->with('exams')->orderBy('id')->get();
        $weeksDesbloqueadas = $course->weeks->take($purchase->weeks_unlocked);

        // Construir combined de forma más robusta ordenando por semana
        $combined = [];
        $usedBlockIds = [];
        
        // Crear un mapeo de semanas por ID
        $weekById = [];
        foreach ($course->weeks as $w) {
            $weekById[$w->id] = $w;
        }
        
        foreach ($weeksDesbloqueadas as $week) {
            $combined[] = ['type' => 'week', 'data' => $week, 'order' => $week->number];
            
            // Buscar bloques que vienen después de esta semana
            foreach ($bloquesEvaluacion as $block) {
                // Verificar si el bloque tiene after_week_id igual al ID de la semana actual
                if ($block->after_week_id && $block->after_week_id == $week->id && !in_array($block->id, $usedBlockIds)) {
                    $combined[] = ['type' => 'evaluation', 'data' => $block, 'order' => $week->number + 0.5];
                    $usedBlockIds[] = $block->id;
                }
            }
        }

        // Prepara los datos para la tabla y gráficas
        $tabla = [];
        $labels = [];
        $scores = [];
        $averageTimes = [];
        $correctAnswers = [];
        $totalQuestions = [];
        $examTypes = []; // AGREGAR ESTE ARRAY
        $examenesAgregados = [];

        // 1. Exámenes de las semanas
        foreach ($course->weeks as $week) {
            if ($week->exam_id) {
                $exam = \App\Models\Exam::find($week->exam_id);
                if ($exam && !in_array($exam->id, $examenesAgregados)) {
                    $result = \App\Models\ExamResult::where('user_id', auth()->id())
                        ->where('exam_id', $exam->id)
                        ->first();

                    $tabla[] = [
                        'examen' => $exam->title ?? "Examen {$exam->id}",
                        'puntaje' => $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : null,
                        'tiempo' => $result->average_time ?? null,
                        'correctas' => $result->correct_answers ?? null,
                        'total' => $result->total_questions ?? null,
                    ];

                    $labels[] = $exam->title ?? "Examen {$exam->id}";
                    $scores[] = $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : 0;
                    $averageTimes[] = $result->average_time ?? 0;
                    $correctAnswers[] = $result->correct_answers ?? 0;
                    $totalQuestions[] = $result->total_questions ?? 0;
                    $examTypes[] = 'week'; // AGREGAR TIPO
                    $examenesAgregados[] = $exam->id;
                }
            }
        }

        // 2. Exámenes de los bloques de evaluación
        foreach ($course->evaluationBlocks as $block) {
            // Si tienes exam_id directo en el bloque
            if ($block->exam_id) {
                $exam = \App\Models\Exam::find($block->exam_id);
                if ($exam && !in_array($exam->id, $examenesAgregados)) {
                    $result = \App\Models\ExamResult::where('user_id', auth()->id())
                        ->where('exam_id', $exam->id)
                        ->first();

                    $tabla[] = [
                        'examen' => $exam->title ?? "Examen {$exam->id}",
                        'puntaje' => $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : null,
                        'tiempo' => $result->average_time ?? null,
                        'correctas' => $result->correct_answers ?? null,
                        'total' => $result->total_questions ?? null,
                    ];

                    $labels[] = $exam->title ?? "Examen {$exam->id}";
                    $scores[] = $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : 0;
                    $averageTimes[] = $result->average_time ?? 0;
                    $correctAnswers[] = $result->correct_answers ?? 0;
                    $totalQuestions[] = $result->total_questions ?? 0;
                    $examTypes[] = 'evaluation'; // AGREGAR TIPO
                    $examenesAgregados[] = $exam->id;
                }
            }
            // Si tienes relación de varios exámenes por bloque
            if (method_exists($block, 'exams')) {
                foreach ($block->exams as $exam) {
                    if ($exam && !in_array($exam->id, $examenesAgregados)) {
                        $result = \App\Models\ExamResult::where('user_id', auth()->id())
                            ->where('exam_id', $exam->id)
                            ->first();

                        $tabla[] = [
                            'examen' => $exam->title ?? "Examen {$exam->id}",
                            'puntaje' => $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : null,
                            'tiempo' => $result->average_time ?? null,
                            'correctas' => $result->correct_answers ?? null,
                            'total' => $result->total_questions ?? null,
                        ];

                        $labels[] = $exam->title ?? "Examen {$exam->id}";
                        $scores[] = $result && $result->total_questions ? round(($result->correct_answers / $result->total_questions) * 100, 2) : 0;
                        $averageTimes[] = $result->average_time ?? 0;
                        $correctAnswers[] = $result->correct_answers ?? 0;
                        $totalQuestions[] = $result->total_questions ?? 0;
                        $examTypes[] = 'evaluation'; // AGREGAR TIPO
                        $examenesAgregados[] = $exam->id;
                    }
                }
            }
        }

        // Pasa todo a la vista
        return view('student.courses.course', compact(
            'course',
            'combined',
            'tabla',
            'labels',
            'scores',
            'averageTimes',
            'correctAnswers',
            'totalQuestions',
            'examTypes' // AGREGAR ESTA VARIABLE
        ));
    }

    public function recorded($dayId)
    {
        $day = WeekDay::with('week.course')->findOrFail($dayId);
        return view('student.courses.recorded', compact('day'));
    }
}
