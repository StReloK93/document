<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    use HasFactory;

    protected $with = [
        'positions'
    ];


    protected $fillable = [
        'name',
        'reject_type_id',
        'user_id',
    ];

    public function positions()
    {
        return $this->hasMany(PatternUser::class);
    }

    public function reject()
    {
        return $this->belongsTo(RejectTypes::class, 'reject_type_id', 'id');
    }
}
