<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        // ✅ ACTUALIZAR: Gate para verificar si es staff (Admin, Ayudante o Maestro)
        Gate::define('isStaff', function ($user) {
            return in_array($user->role, ['admin', 'ayudante', 'maestro']);
        });

        // ✅ MANTENER: Gate específico para admin (si lo necesitas)
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        // ✅ NUEVO: Gate para ayudante
        Gate::define('isAyudante', function ($user) {
            return $user->role === 'ayudante';
        });

        // ✅ NUEVO: Gate para maestro
        Gate::define('isMaestro', function ($user) {
            return $user->role === 'maestro';
        });

        // ✅ NUEVO: Gate para alumno
        Gate::define('isAlumno', function ($user) {
            return $user->role === 'alumno';
        });
    }
}