<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NegationsList;
class NegationsListController extends Controller
{
    public function index(){
        return NegationsList::all();
    }

    public function store(Request $request){
        return NegationsList::create([
            'description' => $request->name
        ]);
    }

    public function update($id, Request $request){
        $type = NegationsList::find($id);
        $type->description = $request->name;
        $type->save();
        return $type;
    }

    public function destroy($id){
        return NegationsList::find($id)->delete();
    }
}
