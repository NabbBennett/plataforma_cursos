<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamStudentResult extends Model
{
    protected $table = 'exam_results';

    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'total',
        'answers', // si guardas las respuestas en formato JSON
    ];

    // Si usas respuestas como JSON
    protected $casts = [
        'answers' => 'array',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}