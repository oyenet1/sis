<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    // student class clas is been used to avoid clash woth keywords
    public function classes()
    {
        return $this->hasMany(Clas::class);
    }

    // user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}