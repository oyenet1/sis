<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $cast = [
        'entered_at' => 'datetime',
        'leave_at' => 'datetime',
    ];
    public function setDateAttribute($value)
    {
        $this->attributes['left_at'] = (new Carbon($value))->format('H:i A');
    }

    protected $guarded = [];

    // localscope sample
    public function scopeVisitor($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'LIKE', $term)
                ->orWhere('purpose', 'LIKE', $term)
                ->orWhere('phone', 'LIKE', $term)
                ->orWhere('created_at', '>=', $term);
            // ->orwhereHas(function ($query) use ($term) {
            //     $query->where('', 'LIKE', $term);
            // }); for relationship
        });
    }
}