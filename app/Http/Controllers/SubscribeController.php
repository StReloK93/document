<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
class SubscribeController extends Controller
{
    public function check($document_id,Request $request){
        return Subscribe::where('document_id', $document_id)->whereIn('position_id', $request->positions)->update([
            'check' => $request->check,
        ]);
    }

    public function remove($id){
        return Subscribe::where('id',$id)->update([
            'check' => false,
        ]);
    }

}
