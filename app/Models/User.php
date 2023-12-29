<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function newestContact(): HasOne
    {
        return $this->hasOne(Contact::class)->latestOfMany();
    }
    public function oldestContact(): HasOne
    {
        return $this->hasOne(Contact::class)->oldestOfMany();
    }
    // public function emergencyContact(): HasOne
    // {
    //     return $this->hasOne(Contact::class)->ofMany('priority', 'max');
    // }

    public function phoneNumbers()
    {
        return $this->through('contact')->has('phoneNumber');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];
}
