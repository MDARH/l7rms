<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guard = [];

    public function student()
    {
        $this->belongsTo(\App\User::class);
    }
}
