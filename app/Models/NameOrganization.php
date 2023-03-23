<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NameOrganization extends Model
{
    use HasFactory;

    protected $connection= 'tatil';

    protected $table = 'organizations';
}
