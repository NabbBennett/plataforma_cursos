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

    // Relación muchos a muchos con semanas
    public function weeks()
    {
        return $this->belongsToMany(Week::class, 'resource_week');
    }
}