<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guard = [];

    // relations
    public function students()
    {
        return $this->belongsToMany(\App\User::class, 'users_departments');
    }
}
