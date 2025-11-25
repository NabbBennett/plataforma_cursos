<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'course_id',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'average_time',
        'total_duration',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function exam()     { return $this->belongsTo(Exam::class); }
    public function answers()  { return $this->hasMany(ExamAnswer::class); }
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'exam_result_id');
    }

    public function scorePercent(): float
    {
        return $this->total_questions > 0
            ? round(($this->correct_answers / $this->total_questions) * 100, 2)
            : 0;
    }
}
