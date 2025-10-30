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
        return view('auth.verify-code');
    }

    public function checkCode(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user || $user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'El código es incorrecto o el usuario no existe.']);
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        Auth::login($user);
        return redirect()->route('profile.profile')->with('success', 'Correo verificado con éxito');
    }

    public function resendCode(Request $request){
        $user = User::find($request->user_id);

        if (!$user) {
            return back()->withErrors(['email' => 'No se pudo encontrar al usuario.']);
        }

        // Regenerar nuevo código
        $user->verification_code = mt_rand(100000, 999999);
        $user->save();

        Mail::to($user->email)->send(new VerifyCodeMail($user));

        return back()->with('resent', 'Se ha reenviado el código de verificación a tu correo.');
    }
}