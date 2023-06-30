<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
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

    // teachers relationship
    function user()
    {
        return $this->belongsTo(User::class);
    }

    // subject relationship
    function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    // day relationship
    function day()
    {
        return $this->belongsTo(Day::class);
    }
    // clas relationship
    function clas()
    {
        return $this->belongsTo(Clas::class);
    }

    // clas relationship
    function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDay($query, $term)
    {
        $query->where('day_id', $term);
    }

    // get the timetable of a particular class and day of the week
    // public function scopeClas($query, $term1, $term2)
    // {
    //     $query->where('clas_id', $term1)
    //         ->where('day_id', $term2);
    // }
    public function scopeMon($query)
    {
        $query->where('day_id', 2);
    }
    public function scopeTue($query)
    {
        $query->where('day_id', 3);
    }
    public function scopeWed($query)
    {
        $query->where('day_id', 4);
    }
    public function scopeThur($query)
    {
        $query->where('day_id', 5);
    }
    public function scopeFri($query)
    {
        $query->where('day_id', 6);
    }
    public function scopeSat($query)
    {
        $query->where('day_id', 7);
    }
    public function scopeSun($query)
    {
        $query->where('day_id', 1);
    }
}