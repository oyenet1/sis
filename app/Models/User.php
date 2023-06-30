<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\Registration;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'email',
        'password',
        'phone',
        'school_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // profile relationships
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // leave relationship
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    // leave relationship
    public function classes()
    {
        return $this->hasMany(Clas::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    static function rolesCount($roles)
    {
        $sum = 0;
        $duplicate = 0;
        foreach ($roles as $key => $value) {
            $sum += Role::find($value)->users()->count();
        }

        foreach (User::all() as $key => $user) {
            if ($user->roles()->count() > 1) {
                $duplicate += $user->roles()->count() - 1;
            }
        }
        return $sum - $duplicate;
    }

    // conversation
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }


    // messages
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // messages
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // departments
    public function department()
    {
        return $this->hasOne(Department::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    function children()
    {
        return $this->hasManyThrough(parent::class, Student::class);
    }


    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    // teachers can screate many scores
    public function scores()
    {
        return $this->hasMany(Score::class);
    }


    public static function boot()
    {
        parent::boot();

        // create a profile together with user_error
        self::created(function ($user) {
            $type = ['teaching', 'non teaching'];
            $user->profile()->create([
                'type' => $type[0],
                'admitted' => Carbon::now(),
                'status' => 'active'
            ]);
        });

        // detach roles from user when deleted
        self::deleted(function ($user) {
            $user->detachRoles($user->roles);
        });

        // creation of automatic school id
        self::creating(function ($model) {
            $model->school_id = IdGenerator::generate(['table' => 'users', 'field' => 'school_id', 'length' => 12, 'prefix' => 'ST/ACK/' . date('y') . '/']);
        });
    }

    public function scopeUser($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term)
                ->orWhere('school_id', 'LIKE', $term)
                ->orWhere('email', 'LIKE', $term);
        })->orWhereHas('profile', function ($query) use ($term) {
            $query->where('type', 'LIKE', $term)
                ->orWhere('status', '=', $term)
                ->orWhere('salary', '=', $term);
        })->orwhereHas('roles', function ($query) use ($term) {
            $query->where('name', $term)
                ->orWhere('display_name', $term);
        });
    }

    public function scopeStaff($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term)
                ->orWhere('school_id', 'LIKE', $term)
                ->orWhere('email', 'LIKE', $term);
        })->orWhereHas('profile', function ($query) use ($term) {
            $query->where('type', 'LIKE', $term)
                ->orWhere('status', 'LIKE', $term);
        })->orWhereHas('roles', function ($query) use ($term) {
            $query->where('id', '!=', [1, 7, 8, 9, 10]) //roles that must not show
                ->orWhere('display_name', 'LIKE', $term);
        });
    }
}