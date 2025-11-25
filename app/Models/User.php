<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

        return $purchase->type === 'full' || 
            $purchase->weeks_unlocked >= $course->weeks->count();
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswer::class);
    }

    public function getAvatarUrlAttribute()
    {
        return asset("images/avatars/avatar{$this->avatar}.jpg");
    }

    public function getBannerUrlAttribute()
    {
        return asset("images/banners/banner{$this->banner}.jpg");
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
}