<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;
    
    protected $with = [
        'position'
    ];

    protected $fillable = [
        'document_id',
        'position_id',
        'check',
    ];

    protected $casts = [
        'check' => 'integer',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
