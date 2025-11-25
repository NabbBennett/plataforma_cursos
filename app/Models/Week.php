<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'exam_id',
        'number',
        'order',
        'title',
        'live_type',
        'live_meet_link',
        'recording_link',
        'resource_id',
        'schedule_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function weekDays()
    {
        return $this->hasMany(WeekDay::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function exams()
    {
        return $this->hasMany(\App\Models\Exam::class);
    }

    // Relación muchos a muchos con recursos (LA QUE FALTABA)
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_week');
    }

    // Mantener relación singular para compatibilidad (si la usabas antes)
    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
}
