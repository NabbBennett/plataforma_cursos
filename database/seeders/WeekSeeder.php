<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Week;
use App\Models\Course;

class WeekSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();
        if (!$course) {
            $course = Course::create([
                'title' => 'Curso de Laravel',
                'description' => 'Un curso intensivo de Laravel para principiantes.',
                'image' => null,
            ]);
        }

        Week::create([
            'course_id' => $course->id,
            'title' => 'Semana 1 - Introducción',
            'number' => 1,
            'live_meet_link' => 'http://meet.google.com/byx-wvyi-ebk',
            'recording_link' => 'https://drive.google.com/file/d/1xFK6daTRRdlsoDi_eVh2kr30qv98OBi1/view?usp=sharing'
        ]);
    }
}
