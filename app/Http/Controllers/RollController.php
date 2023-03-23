<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roll;
class RollController extends Controller
{
    public function index(){
        return Roll::all();
    }
}
