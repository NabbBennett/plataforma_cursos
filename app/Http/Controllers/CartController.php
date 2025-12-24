<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {
    
    // Añadir curso al carrito
    public function add(Request $request, $courseId){
        $course = Course::with(['weeks' => function ($q) {
            $q->orderBy('number');
        }])->findOrFail($courseId);

        $request->validate([
            'weeks_count' => 'required|integer|min:1|max:' . $course->weeks->count(),
        ]);

        $selectedWeeks = $course->weeks->take($request->weeks_count)->pluck('id')->toArray();

        $cart = session()->get('cart', []);

        $cart[$courseId] = [
            'title' => $course->title,
            'price_per_week' => $course->price_per_week,
            'weeks' => $selectedWeeks,
            'max_weeks' => $course->weeks->count(), 
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Curso añadido al carrito.');
    }

    public function update(Request $request, $courseId) {
        $cart = session()->get('cart', []);

        if (!isset($cart[$courseId])) {
            return back()->with('error', 'Curso no encontrado en el carrito.');
        }

        $weeks_count = (int) $request->input('weeks_count');

        $course = \App\Models\Course::with(['weeks' => function ($q) {
            $q->orderBy('number');
        }])->findOrFail($courseId);

        if ($weeks_count < 1 || $weeks_count > $course->weeks->count()) {
            return back()->with('error', 'Cantidad inválida de semanas.');
        }

        $selectedWeeks = $course->weeks->take($weeks_count)->pluck('id')->toArray();

        $cart[$courseId]['weeks'] = $selectedWeeks;
        $cart[$courseId]['max_weeks'] = $course->weeks->count();

        session()->put('cart', $cart);

        return back()->with('success', 'Semanas actualizadas.');
    }

    // Eliminar curso del carrito
    public function remove($courseId){
        $cart = session()->get('cart', []);
        unset($cart[$courseId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Curso eliminado del carrito.');
    }

    // Mostrar carrito
    public function view(){
        $cart = session()->get('cart', []);
        $user = auth()->user();
        $userCourses = $user->purchases->pluck('course_id')->toArray();

        foreach ($cart as $courseId => &$item) {
            $course = \App\Models\Course::find($courseId);

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

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return back()->with('error','Carrito vacío.');

        $user = auth()->user();
        $appliedCoupon = session('applied_coupon');
        $discount = session('discount') ?? 0;

        $subtotal = 0;
        $extra = 0;

        DB::transaction(function() use ($cart, $user, &$subtotal, &$extra, $discount) {
            foreach ($cart as $courseId => $item) {
                $weeks = count($item['weeks']);
                $subtotal += $item['price_per_week'] * $weeks;

                $course = \App\Models\Course::lockForUpdate()->find($courseId);
                $existing = \App\Models\Purchase::where('user_id',$user->id)->where('course_id',$courseId)->first();

                if (!$existing) {
                    if (!is_null($course->capacity) && $course->enrolled_count >= $course->capacity) {
                        throw new \Exception("Curso lleno: {$course->title}");
                    }
                    \App\Models\Purchase::create([
                        'user_id' => $user->id,
                        'course_id' => $courseId,
                        'type' => 'weekly',
                        // Semanas desbloqueadas comienzan en 0; se irán liberando aparte
                        'weeks_unlocked' => 0,
                        'paid_weeks' => $weeks
                    ]);
                    $course->increment('enrolled_count');
                    $extra += 200;
                } else {
                    $existing->increment('paid_weeks', $weeks);
                }
            }
        });

        $total = $subtotal + $extra - $discount;

        $ticketData = [
            'code' => strtoupper(substr(md5(uniqid()),0,10)),
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
            'cart' => $cart,
            'subtotal' => $subtotal,
            'enrollment_fee' => $extra,
            'discount' => $discount,
            'total' => $total,
            'coupon' => $appliedCoupon,
            'created_at' => now()->format('d/m/Y H:i')
        ];

        session()->forget(['cart','applied_coupon','discount']);
        session(['last_ticket' => $ticketData]);

        return redirect()->route('ticket.view')->with('success','Compra procesada.');
    }

    public function ticket()
    {
        $ticket = session('last_ticket');
        if (!$ticket) return redirect()->route('cart.view')->with('error','No hay comprobante disponible.');
        return view('general.car.ticket', compact('ticket'));
    }
}
