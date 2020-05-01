<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        'email_verified_at' => 'datetime',
    ];

    // relations
    public function profile()
    {
        return $this->hasOne(\App\Profile::class);
    }

    public function department()
    {
        return $this->belongsToMany(\App\Department::class, 'users_departments')->withTimestamps();
    }

    public function class()
    {
        return $this->belongsToMany(\App\StudentClass::class, 'users_classes')->withTimestamps();
    }
    
    public function registration()
    {
        return $this->hasOne(\App\Registration::class);
    }

    public function roll()
    {
        return $this->hasOne(\App\Roll::class, 'roll_id');
    }
}
