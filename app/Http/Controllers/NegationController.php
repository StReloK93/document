<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negation;
use Auth;

class NegationController extends Controller
{
    public function add($document_id, Request $request){
        return Negation::create([
            'document_id' => $document_id,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function remove($id){
        return Negation::find($id)->delete();
    }
}
