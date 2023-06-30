<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // clas relationship
    function clas()
    {
        return $this->belongsTo(Clas::class);
    }

    // term relationship
    function term()
    {
        return $this->belongsTo(Term::class);
    }

    // payments relationship
    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $term = trim($term);
        $query->where(function ($query) use ($term) {
            $query->where('amount', 'LIKE', $term)
                ->orWhere('created_at', 'LIKE', $term)
                ->orWhere('type', 'LIKE', $term);
        });
    }
}