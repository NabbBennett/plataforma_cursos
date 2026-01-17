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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function perfil(){
        $user = auth()->user();

        // Obtener las compras del usuario con la información del curso
        $compras = Purchase::with('course')
            ->where('user_id', $user->id)
            ->get();

        // Obtener IDs de cursos comprados
        $cursosCompradosIds = $compras->pluck('course_id')->filter()->toArray();

        // Obtener cursos recomendados (cursos no comprados)
        $cursosRecomendados = Course::whereNotIn('id', $cursosCompradosIds)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('student.profile', compact('user', 'compras', 'cursosRecomendados'));
    }

    public function configuration()
    {
        $user = auth()->user();
        return view('student.configuration.configuration', compact('user'));
    }


    public function updateAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|integer|between:1,6'
        ]);

        $user = auth()->user();
        $user->avatar = $request->avatar;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Avatar actualizado correctamente',
            'avatar_url' => $user->avatar_url
        ]);
    }


    public function updateBanner(Request $request){
        $request->validate([
            'banner' => 'required|integer|between:1,4'
        ]);

        $user = auth()->user();
        $user->banner = $request->banner;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Banner actualizado correctamente',
            'banner_url' => $user->banner_url
        ]);
    }


    public function updateName(Request $request){
        $request->validate([
            'name' => 'required|string|min:2|max:255'
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Nombre actualizado correctamente'
        ]);
    }

    public function updatePassword(Request $request){
        $validator = \Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['La contraseña actual es incorrecta']]
            ], 422);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente'], 200);
    }

    public function showRecorded($dayId) {
        $day = WeekDay::findOrFail($dayId);
        $week = $day->week;
        $days = $week->weekDays()->orderBy('day_number')->get();

        return view('student.courses.recorded', compact('days', 'day'));
    }

    public function viewResource(Request $request, $type, $id)
    {
        if ($type === 'week') {
            $week = \App\Models\Week::with('weekDays')->findOrFail($id);
            $courseId = $week->course_id;

            // Caso 1: semana con recursos por día (weekDays.resource_id)
            $daysWithResources = $week->weekDays()
                ->whereNotNull('resource_id')
                ->orderBy('day_number')
                ->get();

            if ($daysWithResources->isNotEmpty()) {
                $dayParam = $request->query('day');

                if ($dayParam) {
                    $currentDay = $daysWithResources->firstWhere('id', $dayParam) ?? $daysWithResources->first();
                } else {
                    $currentDay = $daysWithResources->first();
                }

                $resource = \App\Models\Resource::findOrFail($currentDay->resource_id);
                $weekId = $week->id;

                return view('student.courses.resources', compact('resource', 'courseId', 'daysWithResources', 'currentDay', 'weekId'));
            }

            // Caso 2: recurso directo en la semana
            if ($week->resource_id) {
                $resource = \App\Models\Resource::findOrFail($week->resource_id);
                return view('student.courses.resources', compact('resource', 'courseId'));
            }

            abort(404, 'No hay recurso asignado.');
        } elseif ($type === 'evaluation') {
            $block = \App\Models\EvaluationBlock::findOrFail($id);

            if (!$block->resource_id) {
                abort(404, 'No hay recurso asignado.');
            }

            $resource = \App\Models\Resource::findOrFail($block->resource_id);
            $courseId = $block->course_id;

            return view('student.courses.resources', compact('resource', 'courseId'));
        }

        abort(404, 'Tipo no válido.');
    }
}
