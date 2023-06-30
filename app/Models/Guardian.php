<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    function students()
    {
        return $this->HasMany(Student::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        // creation of automatic school id
        self::creating(function ($model) {
            $model->parent_id =  IdGenerator::generate(['table' => 'guardians', 'field' => 'parent_id', 'length' => 10, 'prefix' => 'PT/' . date('y') . '/']);
        });
    }
}