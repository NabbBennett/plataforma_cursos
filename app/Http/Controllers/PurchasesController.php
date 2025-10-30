<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Course;
use App\Models\WeekDay;


class PurchasesController extends Controller
{
    public function ventasGlobales()
    {
        $ventas = Purchase::with(['user', 'course'])->get();

        foreach ($ventas as $venta) {
            if ($venta->course && $venta->course->start_date) {
                $inicioCurso = \Carbon\Carbon::parse($venta->course->start_date);
                $semanasDesdeInicio = $inicioCurso->isFuture() ? 0 : now()->diffInWeeks($inicioCurso);
                $venta->atrasado = $venta->paid_weeks + 2 < $semanasDesdeInicio;
            } else {
                $venta->atrasado = false;
            }
        }

        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('title')->get();

        return view('admin.purchases.sales', compact('ventas', 'users', 'courses'));
    }

    public function guardarAccesoManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'paid_weeks' => 'required|integer|min:1',
        ]);

        $course = Course::findOrFail($request->course_id);
        $maxSemanas = $course->number_of_weeks ?? $course->weeks()->count();

        if ($request->paid_weeks > $maxSemanas) {
            return back()->withErrors([
                'paid_weeks' => "No puedes pagar más de $maxSemanas semanas para este curso.",
            ])->withInput();
        }

        $startDate = $course->start_date ? \Carbon\Carbon::parse($course->start_date) : now();
        $semanasTranscurridas = $startDate->isFuture() ? 0 : now()->diffInWeeks($startDate);

        if ($request->paid_weeks + 2 < $semanasTranscurridas) {
            return back()->withErrors([
                'paid_weeks' => "El curso comenzó hace $semanasTranscurridas semanas. Con {$request->paid_weeks} semanas pagadas, el alumno estaría en atraso.",
            ])->withInput();
        }

        Purchase::updateOrCreate(
            ['user_id' => $request->user_id, 'course_id' => $request->course_id],
            [
                'type' => 'manual',
                'paid_weeks' => $request->paid_weeks,
                'weeks_unlocked' => $request->paid_weeks, // 💡 CORRECTO: igual a las pagadas
                'start_date' => $startDate,
            ]
        );

        return back()->with('success', 'Acceso registrado correctamente.');
    }

    public function actualizarCampos(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'field' => 'required|in:weeks_unlocked,paid_weeks',
            'value' => 'required|integer|min:0',
        ]);

        $purchase = Purchase::findOrFail($request->purchase_id);
        $course = $purchase->course;

        if ($course) {
            $maxSemanas = $course->number_of_weeks ?? $course->weeks()->count();
            if ($request->value > $maxSemanas) {
                return response()->json([
                    'success' => false,
                    'message' => "No se puede asignar más de $maxSemanas semanas al curso seleccionado."
                ]);
            }
        }

        $purchase->{$request->field} = $request->value;
        $purchase->save();

        return response()->json(['success' => true]);
    }

    public function showRecorded($weekDayId){
        $day = WeekDay::with('week')->findOrFail($weekDayId);
        $week = $day->week; // accede a la relación week

        return view('student.courses.recorded', compact('day'));
    }

}