<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionInformation extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'location',
        'description',
        'careers',
        'admission_dates',
        'recommended_courses',
    ];
}
