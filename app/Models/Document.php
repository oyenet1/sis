<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    // the user who upload a documents
    function owner()
    {
        return $this->belongsTo(User::class);
    }

    function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents');
    }
}