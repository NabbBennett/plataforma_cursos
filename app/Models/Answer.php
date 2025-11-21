<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 
        'text', 
        'image_path',
        'is_correct'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function getImageUrl(){
        return $this->image_path 
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function hasImage(){
        return !empty($this->image_path);
    }
}
