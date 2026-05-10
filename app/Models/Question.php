<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
        if (empty($this->image_path)) {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', $this->image_path), '/');

        if (Storage::disk('public')->exists($path)) {
            return route('public.file', ['path' => $path]);
        }

        return asset('storage/' . $path);
    }

    public function hasImage(){
        return !empty($this->image_path);
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswer::class);
    }
}
