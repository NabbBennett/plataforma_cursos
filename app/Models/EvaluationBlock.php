<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'evaluation_type',
        'after_week_id',
        'live_meet_link',
        'recording_link',
        'exam_id',
    ];

    // Relación con el curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relación con la semana después de la cual se inserta este bloque
    public function afterWeek()
    {
        return $this->belongsTo(Week::class, 'after_week_id');
    }

    // Relación con el examen si aplica
    public function exam()
    {
        return $this->hasOne(Exam::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function exams()
    {
        return $this->hasMany(\App\Models\Exam::class, 'evaluation_block_id');
    }
}
