<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
}
