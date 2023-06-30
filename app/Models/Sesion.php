<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'datetime:Y-m-d',
        'end' => 'datetime:Y-m-d',
    ];
    protected $guarded = [];

    function terms()
    {
        return $this->hasMany(Term::class);
    }
}