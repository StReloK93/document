<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganizations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id'
    ];

    protected $casts = [
        'organization_id' => 'integer',
    ];
}
