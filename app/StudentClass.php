<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $guard = [];

    // relations
    public function students()
    {
        return $this->belongsToMany(\App\User::class, 'users_classes');
    }

    public function department()
    {
        return $this->belongsToMany(\App\Department::class, 'departments_classes');
    }

    public function rolls()
    {
        return $this->belongsToMany(\App\Roll::class, 'class_rolles');
    }
}
