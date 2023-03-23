<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolls extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'roll_id'
    ];

    protected $casts = [
        'roll_id' => 'integer',
    ];
}
