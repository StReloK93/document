<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negation extends Model
{
    use HasFactory;

    protected $with = [
        'user'
    ];

    protected $fillable = [
        'document_id',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
