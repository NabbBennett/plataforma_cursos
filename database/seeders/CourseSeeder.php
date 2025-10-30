<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'title' => 'Curso de BUAP',
            'description' => 'Introducción a ser Buapo.',
            'image' => null,
            'weeks' => 4,
        ]);
    }
}
