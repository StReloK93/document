<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPositions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position_id'
    ];


    protected $casts = [
        'position_id' => 'integer',
    ];
}
