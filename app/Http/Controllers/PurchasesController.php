<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Course;
use App\Models\WeekDay;


class PurchasesController extends Controller
{
    private function checkPermission($allowedRoles)
    {
        $user = auth()->user();
        
        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }
    
    public function ventasGlobales(){
        // Paginamos las ventas para mostrar 10 por página
        $ventas = Purchase::with(['user', 'course'])
            ->orderByDesc('created_at')
            ->paginate(10);

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

    public function guardarAccesoManual(Request $request){
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

        // ✅ NUEVO: Verificar si es una nueva compra
        $existingPurchase = Purchase::where('user_id', $request->user_id)
                                    ->where('course_id', $request->course_id)
                                    ->first();

        // ✅ NUEVO: Verificar capacidad solo para nuevas compras
        if (!$existingPurchase && $course->capacity && $course->available_capacity <= 0) {
            return back()->withErrors([
                'course_id' => "El curso '{$course->title}' no tiene cupos disponibles.",
            ])->withInput();
        }

        Purchase::updateOrCreate(
            ['user_id' => $request->user_id, 'course_id' => $request->course_id],
            [
                'type' => 'manual',
                'paid_weeks' => $request->paid_weeks,
                'weeks_unlocked' => 0, // Semanas desbloqueadas comienzan en 0
                'start_date' => $startDate,
            ]
        );

        // ✅ NUEVO: Disminuir capacidad solo para nuevas compras
        if (!$existingPurchase && $course->capacity) {
            $course->increment('enrolled_count');
            \Log::info("Capacidad disminuida manualmente para curso {$course->title}. Nueva capacidad: {$course->available_capacity}");
        }

        return back()->with('success', 'Acceso registrado correctamente.');
    }

    public function actualizarCampos(Request $request){
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

    public function destroy(Purchase $purchase){
        try {
            // Guardar referencia al curso antes de eliminar
            $course = $purchase->course;
            
            // Verificar si esta es la única compra de este usuario para este curso
            $otherPurchasesCount = Purchase::where('user_id', $purchase->user_id)
                ->where('course_id', $purchase->course_id)
                ->where('id', '!=', $purchase->id)
                ->count();

            // Eliminar la purchase
            $purchase->delete();

            // ✅ NUEVO: Restaurar capacidad solo si no hay otras compras del mismo usuario para el mismo curso
            if ($otherPurchasesCount === 0 && $course->capacity) {
                if ($course->enrolled_count > 0) {
                    $course->decrement('enrolled_count');
                }
                \Log::info("Capacidad restaurada para curso {$course->title}. Nueva capacidad: {$course->available_capacity}");
            }

            return redirect()->route('admin.purchases.sales')->with('success', 'Venta eliminada correctamente' . ($otherPurchasesCount === 0 && $course->capacity ? ' y capacidad del curso restaurada.' : '.'));
        } catch (\Exception $e) {
            return redirect()->route('admin.purchases.sales')->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:full,weekly'
        ]);

        $course = Course::findOrFail($request->course_id);

        // ✅ MEJORADO: Verificar cupos disponibles usando available_capacity
        if ($course->capacity && $course->available_capacity <= 0) {
            return back()->with('error', 'Lo sentimos, este curso ya no tiene cupos disponibles.');
        }

        $user = auth()->user();

        // Verificar si ya compró el curso
        $existingPurchase = Purchase::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingPurchase) {
            return back()->with('error', 'Ya has comprado este curso.');
        }

        // Crear la compra
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'type' => $request->type,
            // Semanas desbloqueadas siempre inician en 0; se gestionan aparte
            'weeks_unlocked' => 0,
            'paid_weeks' => $request->type === 'full' ? $course->number_of_weeks : 1
        ]);

        // ✅ NUEVO: Disminuir capacidad disponible
        if ($course->capacity) {
            $course->increment('enrolled_count');
            \Log::info("Capacidad disminuida para curso {$course->title}. Nueva capacidad: {$course->available_capacity}");
        }

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Compra realizada exitosamente.');
    }
}