<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // department(Engish and arabic) relationship with roles
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}