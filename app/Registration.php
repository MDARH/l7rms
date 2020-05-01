<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guard = [];

    // relations
    public function student()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function roll()
    {
        return $this->belongsTo(\App\Roll::class);
    }
}
