<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Statistic;
use App\Models\Course;
use App\Models\Week;
use App\Models\Exam;
use App\Models\WeekDay;

class ProfileController extends Controller
{
   public function perfil(){
        $user = auth()->user();

        // Obtener las compras del usuario con la información del curso
        $compras = Purchase::with('course')
            ->where('user_id', $user->id)
            ->get();

        return view('student.profile', compact('user', 'compras'));
    }

    public function showRecorded($dayId) {
        $day = WeekDay::findOrFail($dayId);
        $week = $day->week;
        $days = $week->weekDays()->orderBy('day_number')->get();

        return view('student.courses.recorded', compact('days', 'day'));
    }

    public function viewResource($type, $id)
    {
        if ($type === 'week') {
            $model = \App\Models\Week::findOrFail($id);
        } elseif ($type === 'evaluation') {
            $model = \App\Models\EvaluationBlock::findOrFail($id);
        } else {
            abort(404, 'Tipo no válido.');
        }

        if (!$model->resource_id) {
            abort(404, 'No hay recurso asignado.');
        }

        $resource = \App\Models\Resource::findOrFail($model->resource_id);
        $courseId = $model->course_id;

        return view('student.courses.resources', compact('resource', 'courseId'));
    }
}
