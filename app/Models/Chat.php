<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
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

        // update the updated_at of the conversation when a new message is created.
        self::created(function ($chat) {
            $chat->conversation()->update([
                'updated_at' => Carbon::now(),
            ]);
        });
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}