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
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['La contraseña actual es incorrecta']]
            ], 422);
        }

        // Verificar que la nueva contraseña no sea igual a la actual
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['new_password' => ['La nueva contraseña no puede ser igual a la actual']]
            ], 422);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente'
        ]);
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
