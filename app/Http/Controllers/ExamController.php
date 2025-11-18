<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    public function index(){
        $exams = Exam::withCount('questions')->latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function create(){
        return view('admin.exams.create');
    }

    public function store(Request $request){
        $request->validate([
        'title' => 'required|string|max:255',
        'duration_minutes' => 'required|integer|min:1',
        'questions' => 'required|array|min:1',
        // permitir text/answer como nullable; validación más específica abajo
        'questions.*.text' => 'nullable|string',
        'questions.*.theme' => 'nullable|string|max:255',
        'questions.*.correct' => 'nullable|string',
        'questions.*.wrong1' => 'nullable|string',
        'questions.*.wrong2' => 'nullable|string',
        'questions.*.wrong3' => 'nullable|string',
    ]);

    // Validación adicional: checar por cada pregunta que tenga texto O imagen,
    // que la respuesta correcta tenga texto O imagen y que exista al menos una respuesta incorrecta (texto o imagen)
    foreach ($request->questions as $i => $q) {
        $hasQuestionText = !empty(trim($q['text'] ?? ''));
        $hasQuestionImage = $request->hasFile("questions.$i.image");

        if (! $hasQuestionText && ! $hasQuestionImage) {
            return back()->withErrors([
                "questions.$i" => "La pregunta #".($i+1)." debe tener texto o una imagen."
            ])->withInput();
        }

        $hasCorrectText = !empty(trim($q['correct'] ?? ''));
        $hasCorrectImage = $request->hasFile("questions.$i.correct_image");

        if (! $hasCorrectText && ! $hasCorrectImage) {
            return back()->withErrors([
                "questions.$i.correct" => "La pregunta #".($i+1)." debe tener la respuesta correcta (texto o imagen)."
            ])->withInput();
        }

        // Al menos una respuesta incorrecta (wrong1 es obligatoria por UI): text o image disponibles
        $wrongChecks = [
            (!empty(trim($q['wrong1'] ?? '')) || $request->hasFile("questions.$i.wrong1_image")),
            (!empty(trim($q['wrong2'] ?? '')) || $request->hasFile("questions.$i.wrong2_image")),
            (!empty(trim($q['wrong3'] ?? '')) || $request->hasFile("questions.$i.wrong3_image")),
        ];

        if (! $wrongChecks[0] && ! $wrongChecks[1] && ! $wrongChecks[2]) {
            return back()->withErrors([
                "questions.$i" => "La pregunta #".($i+1)." debe tener al menos una respuesta incorrecta (texto o imagen)."
            ])->withInput();
        }
    }

    $exam = Exam::create([
        'title' => $request->title,
        'duration_minutes' => $request->duration_minutes,
    ]);

    foreach ($request->questions as $index => $q) {
        // Determinar contenido de la pregunta: texto o imagen subida
        $questionTextRaw = trim($q['text'] ?? '');

        if (empty($questionTextRaw) && $request->hasFile("questions.$index.image")) {
            $file = $request->file("questions.$index.image");
            $path = $file->store('public/uploads/exams/questions');
            $url = Storage::url($path);
            $questionTextRaw = '<img src="'. $url .'" alt="Pregunta '.($index+1).'">';
        }

        $question = Question::create([
            'exam_id' => $exam->id,
            'text' => Purifier::clean($questionTextRaw, [
                'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
            ]),
            'theme' => $q['theme'] ?? null,
            'order' => $index + 1,
        ]);

        // Respuesta correcta: texto o imagen
        $correctRaw = trim($q['correct'] ?? '');
        if (empty($correctRaw) && $request->hasFile("questions.$index.correct_image")) {
            $file = $request->file("questions.$index.correct_image");
            $path = $file->store('public/uploads/exams/answers');
            $url = Storage::url($path);
            $correctRaw = '<img src="'. $url .'" alt="Respuesta correcta">';
        }

        Answer::create([
            'question_id' => $question->id,
            'text' => Purifier::clean($correctRaw),
            'is_correct' => true,
        ]);

        // Respuestas incorrectas: wrong1, wrong2, wrong3
        foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
            $answerRaw = trim($q[$key] ?? '');

            if (empty($answerRaw) && $request->hasFile("questions.$index.{$key}_image")) {
                $file = $request->file("questions.$index.{$key}_image");
                $path = $file->store('public/uploads/exams/answers');
                $url = Storage::url($path);
                $answerRaw = '<img src="'. $url .'" alt="Respuesta">';
            }

            if (!empty($answerRaw)) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => Purifier::clean($answerRaw),
                    'is_correct' => false,
                ]);
            }
        }
    }

    return redirect()->route('admin.exams.index')->with('success', 'Examen creado correctamente.');
}

    public function edit(Exam $exam){
        $examData = [
            'title' => $exam->title,
            'duration_minutes' => $exam->duration_minutes,
            'questions' => $exam->questions->map(function($question) {
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                $wrongAnswers = $question->answers->where('is_correct', false)->values();
                
                return [
                    'id' => $question->id,
                    'text' => $question->text,
                    'theme' => $question->theme,
                    'has_image' => !empty($question->image_path),
                    'image_path' => $question->image_path ? asset('storage/' . $question->image_path) : null,
                    'existing_image' => $question->image_path,
                    'correct_id' => $correctAnswer->id ?? null,
                    'correct_text' => $correctAnswer->text ?? '',
                    'correct_existing_image' => $correctAnswer->image_path ?? '',
                    'wrong1_id' => $wrongAnswers->get(0)->id ?? null,
                    'wrong1_text' => $wrongAnswers->get(0)->text ?? '',
                    'wrong1_existing_image' => $wrongAnswers->get(0)->image_path ?? '',
                    'wrong2_id' => $wrongAnswers->get(1)->id ?? null,
                    'wrong2_text' => $wrongAnswers->get(1)->text ?? '',
                    'wrong2_existing_image' => $wrongAnswers->get(1)->image_path ?? '',
                    'wrong3_id' => $wrongAnswers->get(2)->id ?? null,
                    'wrong3_text' => $wrongAnswers->get(2)->text ?? '',
                    'wrong3_existing_image' => $wrongAnswers->get(2)->image_path ?? '',
                ];
            })->toArray()
        ];

        return view('admin.exams.edit', compact('exam', 'examData'));
    }

    public function update(Request $request, Exam $exam){
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'nullable|string',
            'questions.*.theme' => 'nullable|string|max:255',
            'questions.*.correct' => 'nullable|string',
            'questions.*.wrong1' => 'nullable|string',
            'questions.*.wrong2' => 'nullable|string',
            'questions.*.wrong3' => 'nullable|string',
        ]);

        // Validaciones adicionales (misma lógica que en store)
        foreach ($request->questions as $i => $q) {
            $hasQuestionText = !empty(trim($q['text'] ?? ''));
            $hasQuestionImage = $request->hasFile("questions.$i.image");

            if (! $hasQuestionText && ! $hasQuestionImage) {
                return back()->withErrors([
                    "questions.$i" => "La pregunta #".($i+1)." debe tener texto o una imagen."
                ])->withInput();
            }

            $hasCorrectText = !empty(trim($q['correct'] ?? ''));
            $hasCorrectImage = $request->hasFile("questions.$i.correct_image");

            if (! $hasCorrectText && ! $hasCorrectImage) {
                return back()->withErrors([
                    "questions.$i.correct" => "La pregunta #".($i+1)." debe tener la respuesta correcta (texto o imagen)."
                ])->withInput();
            }

            $wrongChecks = [
                (!empty(trim($q['wrong1'] ?? '')) || $request->hasFile("questions.$i.wrong1_image")),
                (!empty(trim($q['wrong2'] ?? '')) || $request->hasFile("questions.$i.wrong2_image")),
                (!empty(trim($q['wrong3'] ?? '')) || $request->hasFile("questions.$i.wrong3_image")),
            ];

            if (! $wrongChecks[0] && ! $wrongChecks[1] && ! $wrongChecks[2]) {
                return back()->withErrors([
                    "questions.$i" => "La pregunta #".($i+1)." debe tener al menos una respuesta incorrecta (texto o imagen)."
                ])->withInput();
            }
        }

        foreach ($request->questions as $i => $q) {
            if (empty($q['wrong1']) && empty($q['wrong2']) && empty($q['wrong3'])) {
                // ya cubierto por validación anterior; dejar por compatibilidad
            }
        }

        $exam->update([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes,
        ]);

        $exam->questions()->each(function ($q) {
            $q->answers()->delete();
            $q->delete();
        });

        foreach ($request->questions as $index => $q) {
            $questionTextRaw = trim($q['text'] ?? '');

            if (empty($questionTextRaw) && $request->hasFile("questions.$index.image")) {
                $file = $request->file("questions.$index.image");
                $path = $file->store('public/uploads/exams/questions');
                $url = Storage::url($path);
                $questionTextRaw = '<img src="'. $url .'" alt="Pregunta '.($index+1).'">';
            }

            $question = Question::create([
                'exam_id' => $exam->id,
                'text' => Purifier::clean($questionTextRaw, [
                    'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                    'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                    'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
                ]),
                'theme' => $q['theme'] ?? null,
                'order' => $index + 1,
            ]);

            $correctRaw = trim($q['correct'] ?? '');
            if (empty($correctRaw) && $request->hasFile("questions.$index.correct_image")) {
                $file = $request->file("questions.$index.correct_image");
                $path = $file->store('public/uploads/exams/answers');
                $url = Storage::url($path);
                $correctRaw = '<img src="'. $url .'" alt="Respuesta correcta">';
            }

            Answer::create([
                'question_id' => $question->id,
                'text' => Purifier::clean($correctRaw),
                'is_correct' => true,
            ]);

            foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
                $answerRaw = trim($q[$key] ?? '');

                if (empty($answerRaw) && $request->hasFile("questions.$index.{$key}_image")) {
                    $file = $request->file("questions.$index.{$key}_image");
                    $path = $file->store('public/uploads/exams/answers');
                    $url = Storage::url($path);
                    $answerRaw = '<img src="'. $url .'" alt="Respuesta">';
                }

                if (!empty($answerRaw)) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => Purifier::clean($answerRaw),
                        'is_correct' => false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.exams.index')->with('success', 'Examen actualizado correctamente.');
    }

    public function preview(Exam $exam){
        $exam->load('questions.answers');
        return view('admin.exams.preview', compact('exam'));
    }

    public function destroy(Exam $exam){
        if ($exam->week_id || $exam->evaluation_block_id) {
            return back()->with('error', 'No puedes eliminar un examen asignado.');
        }

        $exam->questions()->each(function ($question) {
            $question->answers()->delete();
            $question->delete();
        });

        $exam->delete();

        return back()->with('success', 'Examen eliminado correctamente.');
    }
}