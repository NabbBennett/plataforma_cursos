<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerifyCodeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller {   


    public function showRegisterForm() {
        return view('auth.login');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_mobile' => 'required|string|size:10|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $code = mt_rand(100000, 999999);

        $user = new User();
        $user->name = $request->name;
        $user->phone_mobile = $request->phone_mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'student';
        $user->verification_code = $code;
        $user->save();

        Mail::to($user->email)->send(new VerifyCodeMail($user));

        // No logueamos aún, hasta que confirme el correo
        return redirect()->route('verification.form')->with('user_id', $user->id);
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            //Verificación de correo
            if (is_null($user->email_verified_at)) {
                Auth::logout(); // Cerramos sesión porque no debe avanzar
                return redirect()->route('verification.form')->with([
                    'user_id' => $user->id,
                    'error' => 'Debes verificar tu correo electrónico antes de continuar.'
                ]);
            }

            //Redirección según rol
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('student.profile');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    public function forgotPassword(Request $request) {
        $request->validate(["email" => "required|email"]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('login')->with("status", "¡Correo enviado! Revisa tu bandeja de entrada o spam.")
            : back()->withErrors(["email" => __($status)]);
    }

    public function showForgotPasswordForm() {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request) {
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => "required|min:6|confirmed",
        ]);

        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route("login")->with("status", __($status))
            : back()->withErrors(["email" => [__($status)]]);
    }

    public function showResetPasswordForm($token) {
        return view('auth.reset-password', ['token' => $token]);
    }
}
