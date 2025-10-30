<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'price_per_week',
        'number_of_weeks',
        'image'
    ];

    public function weeks(){
        return $this->hasMany(Week::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function days(){
        return $this->hasMany(WeekDay::class);
    }

    public function evaluationBlocks(){
        return $this->hasMany(EvaluationBlock::class)->orderBy('after_week_id');
    }

    public function exams()
    {
        return $this->hasMany(\App\Models\Exam::class);
    }
}
