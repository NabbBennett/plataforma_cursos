<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_result_id',
        'question_id',
        'selected_answer_id',
        'correct_answer_id',
        'topic',
    ];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedAnswer()
    {
        return $this->belongsTo(Answer::class, 'selected_answer_id');
    }

    public function correctAnswer()
    {
        return $this->belongsTo(Answer::class, 'correct_answer_id');
    }
}
