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

        $course = Course::findOrFail($id); // $id es el curso
        $userId = auth()->id(); // usuario autenticado

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
            'evaluationBlocks'
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
        $bloquesEvaluacion = $course->evaluationBlocks;
        $weeksDesbloqueadas = $course->weeks->take($purchase->weeks_unlocked);

        $combined = [];
        foreach ($weeksDesbloqueadas as $week) {
            $combined[] = ['type' => 'week', 'data' => $week];
            $block = $bloquesEvaluacion->firstWhere('after_week_id', $week->id);
            if ($block) {
                $combined[] = ['type' => 'evaluation', 'data' => $block];
            }
        }

        // Obtén todos los exámenes del curso
        $course = Course::with('exams')->findOrFail($id);
        $exams = $course->exams ?? collect();
        //$exams = $exams->unique('id');

        // Depuración: obtén todos los exámenes relacionados a este curso por week y evaluation block
        $exams = collect();
        // Obtén los exámenes de las semanas en orden
        foreach ($course->weeks as $week) {
            if (method_exists($week, 'exams')) {
                foreach ($week->exams as $exam) {
                    $exams->push([
                        'type' => 'week',
                        'week' => $week,
                        'exam' => $exam
                    ]);
                }
            }
        }

        // Luego, agrega los exámenes de los bloques de evaluación en el orden que aparecen en el curso
        foreach ($course->evaluationBlocks as $block) {
            if (method_exists($block, 'exams')) {
                foreach ($block->exams as $exam) {
                    $exams->push([
                        'type' => 'evaluation',
                        'block' => $block,
                        'exam' => $exam
                    ]);
                }
            }
            if ($block->exam_id) {
                $exam = \App\Models\Exam::find($block->exam_id);
                if ($exam) {
                    $exams->push([
                        'type' => 'evaluation',
                        'block' => $block,
                        'exam' => $exam
                    ]);
                }
            }
        }

        // Elimina duplicados por id de examen
        $exams = $exams->unique(function($item) {
            return $item['exam']->id;
        });

        // Obtén los resultados del usuario para esos exámenes
        $examIds = $exams->pluck('exam.id');
        $examResults = \App\Models\ExamResult::where('user_id', auth()->id())
            ->whereIn('exam_id', $examIds)
            ->get()
            ->keyBy('exam_id');

        // Prepara los datos para la tabla y gráficas
        $tabla = [];
        $labels = [];
        $scores = [];
        $averageTimes = [];
        $correctAnswers = [];
        $totalQuestions = [];
        $examenesAgregados = []; // Para evitar duplicados

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
            'totalQuestions'
        ));
    }

    public function recorded($dayId)
    {
        $day = WeekDay::with('week.course')->findOrFail($dayId);
        return view('student.courses.recorded', compact('day'));
    }
}
