<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // the sender of the message
    function sender()
    {
        return $this->belongsTo(User::class);
    }

    // the sender of the message
    function receivers()
    {
        return $this->hasMany(MessageUser::class);
    }
}