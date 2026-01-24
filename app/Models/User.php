<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'phone_mobile', 
        'password', 
        'role',
        'avatar', 
        'banner'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'used_first_coupon' => 'boolean',
    ];

    protected $attributes = [
        'avatar' => 1,
        'banner' => 1,
    ];

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function hasPurchasedAllModules($course){
        $purchase = $this->purchases()
            ->where('course_id', $course->id)
            ->first();

        if (!$purchase) {
            return false;
        }

        // Se considera que compró todos los módulos si es compra completa
        // o si las semanas pagadas cubren todas las semanas del curso.
        return $purchase->type === 'full' || 
            $purchase->paid_weeks >= $course->weeks->count();
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswer::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }

    public function courseReviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function getAvatarUrlAttribute()
    {
        return asset("images/avatars/avatar{$this->avatar}.jpg");
    }

    public function getBannerUrlAttribute()
    {
        return asset("images/banners/banner{$this->banner}.jpg");
    }

    protected static function booted()
    {
        parent::booted();

        static::deleting(function (User $user) {
            // Eliminar compras del usuario
            $user->purchases()->delete();

            // Eliminar respuestas de práctica del usuario
            $user->userAnswers()->delete();

            // Eliminar estadísticas de exámenes del usuario
            $user->statistics()->delete();

            // Eliminar resultados de exámenes y sus respuestas
            $user->examResults()->each(function ($result) {
                $result->answers()->delete();
                $result->delete();
            });

            // Eliminar reseñas de cursos hechas por el usuario
            $user->courseReviews()->delete();
        });
    }

    /**
     * Verificar si el usuario es staff (admin, ayudante o maestro)
     */
    public function isStaff()
    {
        return in_array($this->role, ['admin', 'ayudante', 'maestro']);
    }

    /**
     * Verificar si es admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si es ayudante
     */
    public function isAyudante()
    {
        return $this->role === 'ayudante';
    }

    /**
     * Verificar si es maestro
     */
    public function isMaestro()
    {
        return $this->role === 'maestro';
    }

    /**
     * Verificar si es estudiante
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * Usa el mail personalizado con diseño HTML para reset password.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}