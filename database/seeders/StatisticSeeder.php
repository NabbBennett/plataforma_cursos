<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistic;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        // Reemplaza estos IDs según lo que tengas en tu base de datos
        $userId = 2;
        $examId = 1;

        Statistic::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'total_questions' => 10,
            'correct_answers' => 7,
            'wrong_answers' => 3,
            'average_time' => 12.5,
        ]);

        Statistic::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'total_questions' => 15,
            'correct_answers' => 12,
            'wrong_answers' => 3,
            'average_time' => 10.2,
        ]);
    }
}
