<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Week extends Model
{
    use HasFactory;

    // App\Models\Week.php
    protected $fillable = [
        'course_id', 
        'number', 
        'title', 
        'live_meet_link', 
        'recording_link', 
        'exam_id', 
        'resource_id'
    ];


    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function weekDays() {
        return $this->hasMany(\App\Models\WeekDay::class);
    }

    public function exam() {
        return $this->belongsTo(\App\Models\Exam::class);
    }

   public function days(){
        return $this->hasMany(WeekDay::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function exams()
    {
        return $this->hasMany(\App\Models\Exam::class);
    }
}
