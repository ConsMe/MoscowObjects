<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'role', 'accepted', 'subscribed', 'company', 'tel',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'boolean',
    ];

    public function getUserInfoAttribute()
    {
        return $this->only(['name', 'email', 'last_login', 'role', 'subscribed', 'accepted', 'email_verified_at']);
    }

    public function isConfirmed()
    {
        return $this->email_verified_at !== NULL;
    }

    public function isAccepted()
    {
        return $this->isConfirmed() && $this->accepted === 1;
    }

    public function isAdminGroup()
    {
        return $this->isAccepted() && in_array($this->role, ['admin', 'manager']);
    }

    public function favourites()
    {
        return $this->hasMany('App\Favourite');
    }
}
