<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Coupon;
use Illuminate\Support\Carbon;

class StoreController extends Controller
{
    public function show($id){
        // Cargar el curso con semanas y reseñas (incluyendo el usuario que hizo cada reseña)
        $course = Course::with(['weeks', 'reviews.user'])->findOrFail($id);
        return view('general.store.detail', compact('course'));
    }

    public function storeReview(Request $request, $id){
        $course = Course::findOrFail($id);
        
        // Verificar que el usuario ha comprado todos los módulos
        if (!auth()->user()->hasPurchasedAllModules($course)) {
            return back()->with('error', 'Debes completar la compra de todos los módulos para dejar una reseña.');
        }

        // Validar la reseña
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        // Crear o actualizar la reseña
        CourseReview::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'course_id' => $course->id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return back()->with('success', 'Tu reseña ha sido guardada.');
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

    public function cart(){
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

    public function applyCoupon(Request $request){
    $couponCode = trim($request->input('coupon'));
    $user = auth()->user();
    $cart = session()->get('cart', []);
    
    // Validar que hay productos en el carrito
    if (empty($cart)) {
        session([
            'discount' => 0,
            'coupon_error' => 'El carrito está vacío. Agrega productos antes de aplicar un cupón.',
            'coupon_success' => null,
            'applied_coupon' => null
        ]);
        return redirect()->route('cart.view');
    }

    // Buscar el cupón en la base de datos
    $coupon = Coupon::where('code', $couponCode)->first();

    // Validar el cupón
    if (!$coupon) {
        session([
            'discount' => 0,
            'coupon_error' => 'Cupón no válido.',
            'coupon_success' => null,
            'applied_coupon' => null
        ]);
        return redirect()->route('cart.view');
    }

    // Validar si el cupón está activo
    if (!$coupon->is_active) {
        session([
            'discount' => 0,
            'coupon_error' => 'Este cupón no está activo.',
            'coupon_success' => null,
            'applied_coupon' => null
        ]);
        return redirect()->route('cart.view');
    }

    // Validar fecha de expiración
    if ($coupon->expires_at && Carbon::now()->gt($coupon->expires_at)) {
        session([
            'discount' => 0,
            'coupon_error' => 'Este cupón ha expirado.',
            'coupon_success' => null,
            'applied_coupon' => null
        ]);
        return redirect()->route('cart.view');
    }

    // Validar límite de usos
    if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
        session([
            'discount' => 0,
            'coupon_error' => 'Este cupón ha alcanzado su límite de usos.',
            'coupon_success' => null,
            'applied_coupon' => null
        ]);
        return redirect()->route('cart.view');
    }

    // Calcular el subtotal del carrito (SOLO SEMANAS) - CON DEBUG DETALLADO
    $subtotal = 0;
    $extra = 0;
    $userCourses = $user->purchases->pluck('course_id')->toArray();
    
    \Log::info('=== DEBUG CARRITO DETALLADO ===');
    foreach ($cart as $courseId => $item) {
        // Si $item['weeks'] es un array, contar cuántas semanas hay
        $weeksCount = is_array($item['weeks']) ? count($item['weeks']) : $item['weeks'];
        $cursoSubtotal = $item['price_per_week'] * $weeksCount;
        $subtotal += $cursoSubtotal;
        
        // Calcular inscripción ($200 por curso nuevo)
        $esCursoNuevo = !in_array($courseId, $userCourses);
        if ($esCursoNuevo) {
            $extra += 200;
        }

        \Log::info('Curso ID: ' . $courseId, [
            'titulo' => $item['title'],
            'precio_por_semana' => $item['price_per_week'],
            'semanas' => $weeksCount,
            'subtotal_curso' => $cursoSubtotal,
            'es_curso_nuevo' => $esCursoNuevo,
            'inscripcion' => $esCursoNuevo ? 200 : 0
        ]);
    }

    \Log::info('=== TOTALES ===', [
        'subtotal_semanas' => $subtotal,
        'extra_inscripcion' => $extra,
        'total_sin_descuento' => $subtotal + $extra
    ]);

    // Aplicar el descuento solo al SUBTOTAL (semanas)
    $discountAmount = 0;
    
    if ($coupon->discount_type === 'percentage') {
        // Descuento por porcentaje sobre el SUBTOTAL
        $discountAmount = ($subtotal * $coupon->discount_value) / 100;
        $discountMessage = "¡Cupón aplicado! {$coupon->discount_value}% de descuento sobre semanas = $" . number_format($discountAmount, 2);
    } else {
        // Descuento por monto fijo sobre el SUBTOTAL
        $discountAmount = min($coupon->discount_value, ($subtotal + $extra));
        $discountMessage = "¡Cupón aplicado! Descuento de $" . number_format($discountAmount, 2) . " sobre semanas";
    }

    // Debug final
    \Log::info('=== CUPÓN APLICADO ===', [
        'cupon_codigo' => $coupon->code,
        'cupon_tipo' => $coupon->discount_type,
        'cupon_valor_original' => $coupon->discount_value,
        'descuento_aplicado' => $discountAmount,
        'subtotal_semanas' => $subtotal,
        'puede_aplicar_completo' => ($subtotal >= $coupon->discount_value) ? 'SÍ' : 'NO',
        'total_final' => ($subtotal + $extra - $discountAmount)
    ]);

    // Incrementar el contador de usos del cupón
    $coupon->increment('used_count');

    // Guardar información del cupón en la sesión
    session([
        'discount' => $discountAmount,
        'coupon_success' => $discountMessage,
        'coupon_error' => null,
        'applied_coupon' => [
            'code' => $coupon->code,
            'type' => $coupon->discount_type,
            'value' => $coupon->discount_value,
            'discount_amount' => $discountAmount,
            'subtotal' => $subtotal,
            'extra' => $extra
        ]
    ]);

    return redirect()->route('cart.view');
}

    // Método para remover cupón
    public function removeCoupon()
    {
        session([
            'discount' => 0,
            'coupon_success' => null,
            'coupon_error' => null,
            'applied_coupon' => null
        ]);

        return redirect()->route('cart.view');
    }
}