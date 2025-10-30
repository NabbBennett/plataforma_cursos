<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Support\Facades\Hash;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurarse de que el curso existe
        $curso = Course::firstOrCreate(
            ['title' => 'Curso de estilismo de ovejas'],
            ['description' => 'Curso de ejemplo para pruebas', 'number_of_weeks' => 4, 'price_per_week' => 100.00]
        );

        // Crear 5 alumnos y sus compras
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Alumno $i",
                'email' => "alumno$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now()
            ]);

            Purchase::create([
                'user_id' => $user->id,
                'course_id' => $curso->id,
                'type' => 'manual',
                'weeks_unlocked' => rand(1, $curso->number_of_weeks),
            ]);
        }
    }
}
