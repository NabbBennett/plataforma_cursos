<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'phone_mobile', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'used_first_coupon' => 'boolean',
    ];

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswer::class);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
