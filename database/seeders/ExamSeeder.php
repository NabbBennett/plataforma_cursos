<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        for ($e = 1; $e <= 5; $e++) {
            $exam = Exam::create([
                'title' => "Examen de ejemplo $e",
                'duration_minutes' => 5,
            ]);

            for ($q = 1; $q <= 10; $q++) {
                $question = Question::create([
                    'exam_id' => $exam->id,
                    'text' => "<p>¿Cuál es la respuesta correcta de la pregunta $q del examen $e?</p>",
                    'theme' => "Tema $e",
                    'order' => $q,
                ]);

                // Respuesta correcta
                Answer::create([
                    'question_id' => $question->id,
                    'text' => "<p>Respuesta correcta $q</p>",
                    'is_correct' => true,
                ]);
                // Respuestas incorrectas
                for ($w = 1; $w <= 3; $w++) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => "<p>Respuesta incorrecta $w de la pregunta $q</p>",
                        'is_correct' => false,
                    ]);
                }
            }
        }
    }
}
