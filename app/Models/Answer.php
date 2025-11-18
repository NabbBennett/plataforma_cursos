<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 'text', 'is_correct'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

     public function getImageUrl(){
        if (!$this->image_path) {
            return null;
        }

        // Si es una URL absoluta, devolverla directamente
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Si está en storage, usar asset()
        if (strpos($this->image_path, 'storage/') === 0) {
            return asset($this->image_path);
        }

        // Si es una ruta relativa, asumir que está en storage público
        return asset('storage/' . $this->image_path);
    }

    public function imageExists(){
        if (!$this->image_path) {
            return false;
        }

        $path = public_path('storage/' . $this->image_path);
        return file_exists($path);
    }
}
