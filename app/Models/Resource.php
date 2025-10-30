<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'type',
    ];

    // Retorna la URL pública del archivo
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
