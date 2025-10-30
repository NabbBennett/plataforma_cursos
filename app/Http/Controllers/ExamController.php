<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Purifier;

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
        'questions.*.text' => 'required|string',
        'questions.*.theme' => 'nullable|string|max:255',
        'questions.*.correct' => 'required|string',
        'questions.*.wrong1' => 'nullable|string',
        'questions.*.wrong2' => 'nullable|string',
        'questions.*.wrong3' => 'nullable|string',
    ]);

    $exam = Exam::create([
        'title' => $request->title,
        'duration_minutes' => $request->duration_minutes,
    ]);

    foreach ($request->questions as $index => $q) {
        $question = Question::create([
            'exam_id' => $exam->id,
            'text' => Purifier::clean($q['text'], [
                'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
            ]),
            'theme' => $q['theme'] ?? null,
            'order' => $index + 1,
        ]);

        Answer::create([
            'question_id' => $question->id,
            'text' => Purifier::clean($q['correct']),
            'is_correct' => true,
        ]);

        foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
            if (!empty($q[$key])) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => Purifier::clean($q[$key]),
                    'is_correct' => false,
                ]);
            }
        }
    }

    return redirect()->route('admin.exams.index')->with('success', 'Examen creado correctamente.');
}

    public function edit(Exam $exam){
        $exam->load('questions.answers');
        return view('admin.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam){
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.theme' => 'nullable|string|max:255',
            'questions.*.correct' => 'required|string',
            'questions.*.wrong1' => 'nullable|string',
            'questions.*.wrong2' => 'nullable|string',
            'questions.*.wrong3' => 'nullable|string',
        ]);

        foreach ($request->questions as $i => $q) {
            if (empty($q['wrong1']) && empty($q['wrong2']) && empty($q['wrong3'])) {
                return back()->withErrors([
                    "questions.$i" => "La pregunta #" . ($i + 1) . " debe tener al menos una respuesta incorrecta."
                ])->withInput();
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
            $question = Question::create([
                'exam_id' => $exam->id,
                'text' => Purifier::clean($q['text'], [
                    'HTML.Allowed' => 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height|style],br,span',
                    'CSS.AllowedProperties' => 'width,height,background-color,text-align',
                    'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'data' => true],
                ]),
                'theme' => $q['theme'] ?? null,
                'order' => $index + 1,
            ]);

            Answer::create([
                'question_id' => $question->id,
                'text' => Purifier::clean($q['correct']),
                'is_correct' => true,
            ]);

            foreach (['wrong1', 'wrong2', 'wrong3'] as $key) {
                if (!empty($q[$key])) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => Purifier::clean($q[$key]),
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