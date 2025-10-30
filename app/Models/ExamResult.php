<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'course_id', // ✅ Esto es clave
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'average_time',
        'total_duration',
    ];

        public function examStatistic() {
        return $this->hasOne(ExamStatistic::class);
    }

    public function examAnswers(){
        return $this->hasMany(ExamAnswer::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }



}
