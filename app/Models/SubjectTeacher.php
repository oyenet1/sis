<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('clas_id', 'LIKE', $term)
                ->orWhere('subject_id', 'LIKE', $term)
                ->orWhere('user_id', 'LIKE', $term);
        })->orWhereHas('subject', function ($query) use ($term) {
            $query->where('name', 'LIKE', $term)
                ->orWhere('short', 'LIKE', $term);
        })->orWhereHas('user', function ($query) use ($term) {
            $query->where('first_name', 'LIKE', $term)
                ->orWhere('school_id', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term)
                ->orWhere('title', 'LIKE', $term);
        })->orWhereHas('clas', function ($query) use ($term) {
            $query->where('name', $term)
                ->orWhere('section', $term);
        });
    }

    // the  teacher relationship
    function user()
    {
        return $this->belongsTo(User::class);
    }
    // the class
    function clas()
    {
        return $this->belongsTo(Clas::class);
    }
    // the subject
    function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}