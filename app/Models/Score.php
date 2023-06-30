<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // term associated with student scores
    function term()
    {
        return $this->belongsTo(Term::class);
    }

    // student association
    function student()
    {
        return $this->belongsTo(Student::class);
    }


    // teacher association
    function teacher()
    {
        return $this->belongsTo(User::class);
    }


    // subject association
    function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // class association
    function clas()
    {
        return $this->belongsTo(Clas::class);
    }

    // protected static function booted()
    // {
    //     // parent::boot();

    //     // update total mark if any update happens
    //     self::updated(function ($score) {
    //         $score->update([
    //             'total' => totalSubjectScore($score->ca1, $score->ca2, $score->em, $score->pm, $score->bm),
    //         ]);
    //     });
    // }
}