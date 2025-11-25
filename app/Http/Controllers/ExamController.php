<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Storage;
use App\Models\ExamResult;
use App\Models\ExamAnswer;
use App\Models\User;

class ExamController extends Controller
{

     private function checkPermission($allowedRoles)
    {
        $user = auth()->user();
        
        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

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
            'questions.*.text' => 'nullable|string',
            'questions.*.theme' => 'nullable|string|max:255',
            'questions.*.correct' => 'nullable|string',
            'questions.*.wrong1' => 'nullable|string',
            'questions.*.wrong2' => 'nullable|string',
            'questions.*.wrong3' => 'nullable|string',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.correct_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
            // Guardar imagen de pregunta si existe - USANDO LA MISMA LÓGICA QUE EN CURSOS
            $questionImagePath = $request->hasFile("questions.$index.image")
                ? $request->file("questions.$index.image")->store('exams/questions', 'public')
                : null;

            $question = Question::create([
                'exam_id' => $exam->id,
                'text' => Purifier::clean($q['text'] ?? '', [
                    'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                    'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                    'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
                ]),
                'image_path' => $questionImagePath, // ✅ GUARDAR PATH COMO EN CURSOS
                'theme' => $q['theme'] ?? null,
                'order' => $index + 1,
            ]);

            // Guardar imagen de respuesta correcta si existe
            $correctImagePath = $request->hasFile("questions.$index.correct_image")
                ? $request->file("questions.$index.correct_image")->store('exams/answers', 'public')
                : null;

            Answer::create([
                'question_id' => $question->id,
                'text' => Purifier::clean($q['correct'] ?? ''),
                'image_path' => $correctImagePath, // ✅ GUARDAR PATH
                'is_correct' => true,
            ]);

            // Respuestas incorrectas: wrong1, wrong2, wrong3
            foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
                // Guardar imagen de respuesta incorrecta si existe
                $answerImagePath = $request->hasFile("questions.$index.{$key}_image")
                    ? $request->file("questions.$index.{$key}_image")->store('exams/answers', 'public')
                    : null;

                if (!empty(trim($q[$key] ?? '')) || $answerImagePath) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => Purifier::clean($q[$key] ?? ''),
                        'image_path' => $answerImagePath, // ✅ GUARDAR PATH
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
            
            // Función auxiliar para obtener datos de respuesta de forma segura
            $getAnswerData = function($answer, $type = 'answer') {
                if (!$answer) {
                    return [
                        'id' => null,
                        'text' => '',
                        'image_path' => null,
                        'existing_image' => '',
                        'has_image' => false,
                        'image_preview' => ''
                    ];
                }
                
                $imagePath = $answer->image_path ? asset('storage/' . $answer->image_path) : null;
                $imagePreview = $imagePath ? "<img src='{$imagePath}' class='image-preview' alt='Imagen existente'>" : '';
                
                return [
                    'id' => $answer->id,
                    'text' => $answer->text ?? '',
                    'image_path' => $imagePath,
                    'existing_image' => $answer->image_path ?? '',
                    'has_image' => !empty($answer->image_path),
                    'image_preview' => $imagePreview
                ];
            };
            
            $correctData = $getAnswerData($correctAnswer, 'correct');
            $wrong1Data = $getAnswerData($wrongAnswers->get(0), 'wrong1');
            $wrong2Data = $getAnswerData($wrongAnswers->get(1), 'wrong2'); 
            $wrong3Data = $getAnswerData($wrongAnswers->get(2), 'wrong3');
            
            // Datos de la pregunta
            $questionImagePath = $question->image_path ? asset('storage/' . $question->image_path) : null;
            $questionImagePreview = $questionImagePath ? "<img src='{$questionImagePath}' class='image-preview' alt='Imagen de pregunta existente'>" : '';
            
            return [
                'id' => $question->id,
                'text' => $question->text ?? '',
                'theme' => $question->theme ?? '',
                'has_image' => !empty($question->image_path),
                'image_path' => $questionImagePath,
                'existing_image' => $question->image_path ?? '',
                'image_preview' => $questionImagePreview,
                
                // Datos de respuesta correcta
                'correct_id' => $correctData['id'],
                'correct_text' => $correctData['text'],
                'correct_image_path' => $correctData['image_path'],
                'correct_existing_image' => $correctData['existing_image'],
                'correct_image_preview' => $correctData['image_preview'],
                
                // Datos de respuestas incorrectas
                'wrong1_id' => $wrong1Data['id'],
                'wrong1_text' => $wrong1Data['text'],
                'wrong1_image_path' => $wrong1Data['image_path'],
                'wrong1_existing_image' => $wrong1Data['existing_image'],
                'wrong1_image_preview' => $wrong1Data['image_preview'],
                
                'wrong2_id' => $wrong2Data['id'],
                'wrong2_text' => $wrong2Data['text'],
                'wrong2_image_path' => $wrong2Data['image_path'],
                'wrong2_existing_image' => $wrong2Data['existing_image'],
                'wrong2_image_preview' => $wrong2Data['image_preview'],
                
                'wrong3_id' => $wrong3Data['id'],
                'wrong3_text' => $wrong3Data['text'],
                'wrong3_image_path' => $wrong3Data['image_path'],
                'wrong3_existing_image' => $wrong3Data['existing_image'],
                'wrong3_image_preview' => $wrong3Data['image_preview'],
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
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.correct_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.wrong3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $exam->update([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes,
        ]);

        // Eliminar preguntas y respuestas existentes
        $exam->questions()->each(function ($q) {
            // Eliminar imágenes físicas si existen
            if ($q->image_path && Storage::disk('public')->exists($q->image_path)) {
                Storage::disk('public')->delete($q->image_path);
            }
            
            $q->answers()->each(function ($answer) {
                if ($answer->image_path && Storage::disk('public')->exists($answer->image_path)) {
                    Storage::disk('public')->delete($answer->image_path);
                }
            });
            
            $q->answers()->delete();
            $q->delete();
        });

        foreach ($request->questions as $index => $q) {
            // Guardar imagen de pregunta si existe
            $questionImagePath = $request->hasFile("questions.$index.image")
                ? $request->file("questions.$index.image")->store('exams/questions', 'public')
                : null;

            $question = Question::create([
                'exam_id' => $exam->id,
                'text' => Purifier::clean($q['text'] ?? '', [
                    'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                    'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                    'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
                ]),
                'image_path' => $questionImagePath, // ✅ GUARDAR PATH
                'theme' => $q['theme'] ?? null,
                'order' => $index + 1,
            ]);

            // Guardar imagen de respuesta correcta si existe
            $correctImagePath = $request->hasFile("questions.$index.correct_image")
                ? $request->file("questions.$index.correct_image")->store('exams/answers', 'public')
                : null;

            Answer::create([
                'question_id' => $question->id,
                'text' => Purifier::clean($q['correct'] ?? ''),
                'image_path' => $correctImagePath, // ✅ GUARDAR PATH
                'is_correct' => true,
            ]);

            foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
                // Guardar imagen de respuesta incorrecta si existe
                $answerImagePath = $request->hasFile("questions.$index.{$key}_image")
                    ? $request->file("questions.$index.{$key}_image")->store('exams/answers', 'public')
                    : null;

                if (!empty(trim($q[$key] ?? '')) || $answerImagePath) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => Purifier::clean($q[$key] ?? ''),
                        'image_path' => $answerImagePath, // ✅ GUARDAR PATH
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
        $this->checkPermission(['admin']);
        
        if ($exam->week_id || $exam->evaluation_block_id) {
            return back()->with('error', 'No puedes eliminar un examen asignado.');
        }

        $exam->questions()->each(function ($question) {
            // Eliminar imágenes físicas
            if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                Storage::disk('public')->delete($question->image_path);
            }
            
            $question->answers()->each(function ($answer) {
                if ($answer->image_path && Storage::disk('public')->exists($answer->image_path)) {
                    Storage::disk('public')->delete($answer->image_path);
                }
            });
            
            $question->answers()->delete();
            $question->delete();
        });

        $exam->delete();

        return back()->with('success', 'Examen eliminado correctamente.');
    }

    public function doings(Exam $exam)
    {
        $this->checkPermission(['admin', 'maestro', 'ayudante']);


        $results = ExamResult::with('user')
            ->where('exam_id', $exam->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.exams.doings', compact('exam','results'));
    }

    public function results(Exam $exam)
    {
        // Cargar resultados con usuario
        $results = ExamResult::with('user')
            ->where('exam_id', $exam->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.exams.results', compact('exam','results'));
    }

    public function resetResult(Exam $exam, ExamResult $examResult)
    {
        if ($examResult->exam_id !== $exam->id) {
            return back()->with('error','Resultado no corresponde al examen.');
        }
        // Borrar respuestas
        ExamAnswer::where('exam_result_id', $examResult->id)->delete();
        // Borrar resultado
        $examResult->delete();

        return back()->with('success','Intento reiniciado correctamente.');
    }
}