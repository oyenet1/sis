<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        // creation of automatic reference
        self::creating(function ($model) {
            $model->reference =  IdGenerator::generate(['table' => 'payments', 'field' => 'reference', 'length' => 15, 'prefix' => date('y') . 'AC' . strtoupper(date('D'))]);
        });
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('reference', 'LIKE', $term)
                ->orWhere('status', 'LIKE', $term);
        })->orWhereHas('student', function ($query) use ($term) {
            $query->where('student_id', 'LIKE', $term)
                ->orWhere('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term);
        })->orwhereHas('fee', function ($query) use ($term) {
            $query->where('type', 'LIKE', $term)
                ->orWhere('amount', 'LIKE', $term);
        });
    }

    // fee relationship
    function fee()
    {
        return $this->belongsTo(Fee::class);
    }
    // method relationship
    function method()
    {
        return $this->belongsTo(Method::class);
    }
    // student relationship
    function student()
    {
        return $this->belongsTo(Student::class);
    }
}