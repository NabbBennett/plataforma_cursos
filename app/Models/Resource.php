<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path', 
        'type'
    ];

    // Accessor para la URL del archivo
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }
}