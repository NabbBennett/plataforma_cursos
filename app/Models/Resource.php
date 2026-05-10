<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', $this->file_path), '/');

        if (Storage::disk('public')->exists($path)) {
            return route('public.file', ['path' => $path]);
        }

        return Storage::disk('public')->url($path);
    }
}