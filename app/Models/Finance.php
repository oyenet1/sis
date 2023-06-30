<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('description', 'LIKE', $term)
                ->orWhere('amount', 'LIKE', $term)
                ->orWhere('created_at', 'LIKE', $term)
                ->orWhere('type', 'LIKE', $term);
        });
    }
}