<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    protected $guard = [];

    // relations
    public function student()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function registration()
    {
        return $this->hasOne(\App\Registration::class);
    }

    public function class()
    {
        return $this->belongsToMany(\App\StudentClass::class, 'class_rolles');
    }
}
