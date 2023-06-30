<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];
    protected $casts = [
        'admitted' => 'datetime'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')
            ->singleFile()
            ->useFallbackUrl(asset('/img/avatar.png'))
            ->useFallbackPath(public_path('/img/avatar.png'));
    }
}