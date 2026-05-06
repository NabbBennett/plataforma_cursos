<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'week_id',
        'evaluation_block_id',
        'slot_index',
        'duration_minutes'
    ];

    public function week() {
        return $this->belongsTo(Week::class);
    }

    public function questions(){
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function statistics() {
        return $this->hasMany(Statistic::class);
    }

    public function evaluationBlock() {
        return $this->belongsTo(EvaluationBlock::class);
    }

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}
