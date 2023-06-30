<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    // session table relationship
    function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    // fees table relationship
    function fees()
    {
        return $this->hasMany(Fee::class);
    }

    // resumption date of next term

    function resumption(){
        return $this->hasOne(ResumptionDate::class);
    }
}