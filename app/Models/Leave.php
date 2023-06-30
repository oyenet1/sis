<?php

namespace App\Models;

use App\Notifications\LeaveRequestNotification;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\UserLeaveNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        // send notification to users who apply for leave
        self::created(function ($leave) {
            currentUser()->notify(new UserLeaveNotification($leave));


            foreach (admins() as $receiver) {
                $receiver->notify(new LeaveRequestNotification($leave));
            }
        });
    }
}
