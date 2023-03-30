<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganizations extends Model
{
    use HasFactory;

    protected $with = [
        'organization'
    ];

    protected $fillable = [
        'user_id',
        'organization_id'
    ];

    protected $casts = [
        'organization_id' => 'integer',
    ];

    public function organization()
    {
        return $this->belongsTo(NameOrganization::class);
    }
}
