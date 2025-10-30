<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class StoreController extends Controller
{
    public function show($id){
        $course = \App\Models\Course::with('weeks')->findOrFail($id);
        return view('general.store.detail', compact('course'));
    }

    public function store(Request $request)
    {
        $query = Course::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('price')) {
            $query->where('price_per_week', '<=', $request->price);
        }
        if ($request->filled('duration')) {
            $query->whereHas('weeks', function ($q) use ($request) {
                $q->groupBy('course_id')
                  ->havingRaw('COUNT(*) <= ?', [$request->duration]);
            });
        }

        $courses = $query->withCount('weeks')->get();

        // Ejemplo en StoreController
        $user = auth()->user();
        $userWeeks = [];
        if ($user) {
            $userWeeks = $user->purchases()
                ->selectRaw('course_id, SUM(paid_weeks) as weeks')
                ->groupBy('course_id')
                ->pluck('weeks', 'course_id')
                ->toArray();
        }
        return view('general.store.store', compact('courses', 'userWeeks'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $user = auth()->user();
        $userCourses = $user->purchases->pluck('course_id')->toArray();

        foreach ($cart as $courseId => &$item) {
            $course = \App\Models\Course::find($courseId);
            \Log::info('courseId: ' . $courseId);
            \Log::info('course: ' . print_r($course ? $course->toArray() : null, true));

            // Asigna la imagen
            $item['image'] = $course && $course->image ? $course->image : null;

            // Calcula semanas compradas por el usuario para este curso
            $weeksCompradas = $user->purchases()
                ->where('course_id', $courseId)
                ->sum('paid_weeks');
            $item['weeks_compradas'] = $weeksCompradas;

            // Calcula el máximo de semanas que puede comprar
            $weeksTotal = $course ? $course->weeks()->count() : 0;
            $item['max_weeks'] = max($weeksTotal - $weeksCompradas, 0);

            // Asegura que el título y precio estén presentes
            $item['title'] = $course ? $course->title : 'Curso';
            $item['price_per_week'] = $course ? $course->price_per_week : 0;
        }
        unset($item);

        return view('general.car.car', compact('cart', 'userCourses'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = trim($request->input('coupon'));
        $user = auth()->user();

        // Solo este cupón es válido
        $firstPurchaseCoupon = 'TORETO1309';

        // Si ya usó el cupón, no permitirlo de nuevo
        if ($coupon === $firstPurchaseCoupon) {
            // Si ya usó el cupón (puedes usar un campo en la base de datos)
            if ($user->used_first_coupon ?? false) {
                session(['discount' => 0, 'coupon_error' => 'Este cupón solo puede usarse una vez.', 'coupon_success' => null]);
                return redirect()->route('cart.view');
            }

            // Calcula el extra actual
            $cart = session('cart', []);
            $userCourses = $user->purchases->pluck('course_id')->toArray();
            $extra = 0;
            foreach ($cart as $courseId => $item) {
                if (!in_array($courseId, $userCourses)) $extra += 200;
            }

            if ($extra > 0) {
                // Marca el cupón como usado (requiere campo en la tabla users)
                $user->used_first_coupon = true;
                $user->save();

                session([
                    'discount' => $extra,
                    'coupon_success' => 'Cupón aplicado correctamente. El cobro extra por curso nuevo ha sido eliminado.',
                    'coupon_error' => null
                ]);
            } else {
                session([
                    'discount' => 0,
                    'coupon_error' => 'Este cupón solo aplica si compras un curso nuevo.',
                    'coupon_success' => null
                ]);
            }
        } else {
            session(['discount' => 0, 'coupon_error' => 'CUPON INVALIDO', 'coupon_success' => null]);
        }
        return redirect()->route('cart.view');
    }
}
