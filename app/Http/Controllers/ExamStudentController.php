<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Http\Controllers\StadisticController;
use App\Models\ExamResult;
use App\Models\ExamAnswer;
use Illuminate\Support\Facades\Auth;

class ExamStudentController extends Controller
{
    public function start($courseId, $examId){
        $course = Course::findOrFail($courseId);
        $exam = Exam::findOrFail($examId);

        return view('student.courses.exams.start', compact('course', 'exam'));
    }

    public function begin(Request $request, $courseId, $examId){
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $course = Course::findOrFail($courseId); // <--- AGREGA ESTA LÍNEA

        $shuffledAnswers = [];
        foreach ($exam->questions as $question) {
            $shuffledAnswers[$question->id] = $question->answers->shuffle()->pluck('id')->toArray();
        }
        // Guardar en sesión el inicio del examen
        session([
            "exam_{$examId}" => [
                'start_time' => now(),
                'expires_at' => now()->addMinutes($exam->duration_minutes)->toIso8601String(),
                'answers' => [],
                'shuffled_answers' => $shuffledAnswers, // Guardamos el orden
            ]
        ]);

        // Redirigir a la pregunta 1
        return redirect()->route('student.exams.question', [
            'course' => $course->id,
            'exam' => $exam->id,
            'questionNumber' => 1
        ]);
    }

    public function question(Request $request, $courseId, $examId, $questionNumber){
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $course = Course::findOrFail($courseId);

        $question = $exam->questions->sortBy('order')->values()->get($questionNumber - 1);
        if (!$question) abort(404, 'Pregunta no encontrada.');

        // Recuperar el orden barajado
        $sessionData = session("exam_{$examId}", []);
        $shuffledOrder = $sessionData['shuffled_answers'][$question->id] ?? [];

        // Ordenar las respuestas según el orden guardado
        $answers = $question->answers->sortBy(function ($answer) use ($shuffledOrder) {
            return array_search($answer->id, $shuffledOrder);
        })->values();

        // Guardar en la propiedad para la vista
        $question->setRelation('answers', $answers);

        $savedAnswerId = $sessionData['answers'][$question->id] ?? null;
        $answeredQuestions = array_keys($sessionData['answers'] ?? []);

        return view('student.courses.exams.question', compact(
            'course',
            'exam',
            'question',
            'questionNumber',
            'savedAnswerId',
            'answeredQuestions'
        ));
    }

    public function saveAnswer(Request $request, $courseId, $examId){
        $validated = $request->validate([
            'question_id' => 'required|integer',
            'answer_id' => 'required|integer',
        ]);

        $sessionData = session("exam_{$examId}", []);
        $sessionData['answers'][$validated['question_id']] = $validated['answer_id'];
        session(["exam_{$examId}" => $sessionData]);

        return response()->json(['success' => true]);
    }

    public function submit(Request $request, $courseId, $examId){
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $course = Course::findOrFail($courseId);
        $sessionData = session("exam_{$examId}");

        if (!$sessionData) abort(403, 'Examen no iniciado o expirado.');

        $totalQuestions = $exam->questions->count();
        $correct = 0;
        $wrong = 0;

        // Tiempo promedio → (asumiendo duración total / total preguntas)
        $startTime = strtotime($sessionData['start_time']);
        $endTime = time();
        $totalDuration = $endTime - $startTime;
        $averageTime = $totalQuestions > 0 ? round($totalDuration / $totalQuestions, 2) : 0;

        // Primero guarda el resultado general (para tener el ID)
        $examResult = ExamResult::create([
            'user_id' => Auth::id(),
            'exam_id' => $examId,
            'course_id' => $courseId,  // <- Nueva columna
            'total_questions' => $totalQuestions,
            'correct_answers' => 0,
            'wrong_answers' => 0,
            'average_time' => $averageTime,
            'total_duration' => $totalDuration,
        ]);

        // Luego guarda las respuestas
        foreach ($exam->questions as $question) {
            $selectedAnswerId = $sessionData['answers'][$question->id] ?? null;
            $correctAnswer = $question->answers()->where('is_correct', true)->first();

            if ($selectedAnswerId) {
                if ($selectedAnswerId == $correctAnswer->id) {
                    $correct++;
                } else {
                    $wrong++;
                }
            }

        ExamAnswer::create([
            'exam_result_id' => $examResult->id,
            'question_id' => $question->id,
            'selected_answer_id' => $selectedAnswerId ?? null,
            'correct_answer_id' => $correctAnswer->id ?? null,
            'topic' => $question->topic ?? null,
        ]);

        }
        
        // Actualiza el resultado con el score correcto
        $examResult->update([
            'correct_answers' => $correct,
            'wrong_answers' => $wrong,
        ]);

        // Recargar relaciones necesarias
        $examResult->load([
            'examAnswers.question',
            'examAnswers.selectedAnswer',
            'examAnswers.correctAnswer',
        ]);

        session()->forget("exam_{$examId}");

        return view('student.courses.exams.result', compact('course', 'exam', 'examResult', 'totalDuration'));
    }

    public function result($courseId, $examId){
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $course = Course::findOrFail($courseId);

        $examResult = ExamResult::with([
            'examAnswers.question',
            'examAnswers.selectedAnswer',
            'examAnswers.correctAnswer'
        ])->where('exam_id', $examId)
          ->where('course_id', $courseId)
          ->where('user_id', Auth::id())
          ->latest()
          ->firstOrFail();

        return view('student.courses.exams.result', compact('course', 'exam', 'examResult'));
    }

    public function getExamProgress($courseId)
    {
        $userId = auth()->id();
        $course = \App\Models\Course::with('exams')->findOrFail($courseId);
        $exams = $course->exams ?? collect();

        $labels = [];
        $scores = [];
        $averageTimes = [];
        $correctAnswers = [];
        $totalQuestions = [];

        foreach($exams as $exam)
        {
            $result = \App\Models\ExamResult::where('user_id', $userId)
                ->where('exam_id', $exam->id)
                ->latest()
                ->first();

            $labels[] = $exam->title ?? "Examen {$exam->id}";
            $scores[] = $result ? round(($result->correct_answers / $result->total_questions) * 100, 2) : 0;
            $averageTimes[] = $result->average_time ?? 0;
            $correctAnswers[] = $result->correct_answers ?? 0;
            $totalQuestions[] = $result->total_questions ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'scores' => $scores,
            'averageTimes' => $averageTimes,
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
        ]);
    }
}
