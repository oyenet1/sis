<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = ['result'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'dob' => 'date',
        'hobbies' => 'array',
    ];

    function registerMediaCollections(): void
    {
        $this->addMediaCollection('student')
            ->singleFile()
            ->useFallbackUrl(asset('/img/avatar2.png'))
            ->useFallbackPath(public_path('/img/avatar2.png'));

        $this->addMediaCollection('blood')
            ->singleFile()
            ->useFallbackUrl(asset('/img/avatar2.png'))
            ->useFallbackPath(public_path('/img/avatar2.png'));
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // scores
    function scores()
    {
        return $this->hasMany(Score::class);
    }


    function psychomotors()
    {
        return $this->hasMany(Psychomotor::class);
    }

    function affectiveT()
    {
        return $this->hasMany(AffectiveTrait::class);
    }


    function attendance()
    {
        return $this->hasMany(DayPresent::class);
    }

    // student attendance
    function studentAttendance(int $student, int $term)
    {
        return DayPresent::where('term_id', $term)->where('student_id', $student)->first()->present ?? null;
    }

    function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    function clas()
    {
        return $this->belongsTo(Clas::class);
    }

    function studentAccount()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        // creation of automatic school id
        self::creating(function ($model) {
            $model->student_id = IdGenerator::generate(['table' => 'students', 'field' => 'student_id', 'length' => 12, 'prefix' => 'ACCEK/' . date('y') . '/']);
        });


        // creation of automatic student id
        // self::created(function ($model) {
        //     $model->student_id = changeId($model->student_id, $model->clas->school->short);
        // });
    }
}