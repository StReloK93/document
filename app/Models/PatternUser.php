<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatternUser extends Model
{
    use HasFactory;
    
    protected $with = [
        'position'
    ];

    protected $fillable = [
        'pattern_id',
        'position_id',
        'created_at',
        'updated_at'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
