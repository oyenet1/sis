<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clas extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'clas';
    protected $cast = [
        'class_teacher' => 'array',
    ];

    // department relationship
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // section relationship
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // section relationship
    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // profile relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // teacher that teaches relationships
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    // school relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}