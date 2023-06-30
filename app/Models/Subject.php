<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
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
        $term = trim($term);
        $query->where(function ($query) use ($term) {
            $query->where('name', 'LIKE', $term)
                ->orWhere('department_id', 'LIKE', $term);
        });
    }
}