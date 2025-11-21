<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'text',
        'image_path',
        'theme',
        'order',
    ];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function getImageUrl(){
        return $this->image_path 
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function hasImage(){
        return !empty($this->image_path);
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswer::class);
    }
}
