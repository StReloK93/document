<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $with = [
        'rolls',
        'organizations',
        'positions',
        'position'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'password',
        'position_id'
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
        'positions' => 'array',
        'created_at' => 'datetime:Y-m-d H:i'
    ];

    public function organizations()
    {
        return $this->hasMany(UserOrganizations::class);
    }

    public function rolls()
    {
        return $this->hasMany(UserRolls::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function positions()
    {
        return $this->hasMany(UserPositions::class);
    }
}