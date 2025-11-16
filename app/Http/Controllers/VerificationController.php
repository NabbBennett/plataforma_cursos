<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyCodeMail;

class VerificationController extends Controller
{
    public function showForm()
    {
        // Verificar que user_id existe en la sesión
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Sesión expirada. Por favor regístrate nuevamente.');
        }
        
        return view('auth.verify-code');
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'code' => 'required|digits:6'
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return back()->withErrors(['code' => 'Usuario no encontrado.'])->withInput();
        }

        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'El código es incorrecto.'])->withInput();
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        Auth::login($user);
        
        return redirect()->route('profile.profile')->with('success', 'Correo verificado con éxito');
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuario no encontrado.');
        }

        // Regenerar nuevo código
        $user->verification_code = mt_rand(100000, 999999);
        $user->save();

        Mail::to($user->email)->send(new VerifyCodeMail($user));

        // Redirigir de vuelta al formulario de verificación manteniendo el user_id
        return redirect()->route('verification.form')
                         ->with('resent', 'Se ha reenviado el código de verificación a tu correo.')
                         ->with('user_id', $user->id); // ← Esto es importante
    }
}