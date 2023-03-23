<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\UserPositions;
use App\Models\Subscribe;
class PositionController extends Controller
{
    public function index(){
        return Position::all();
    }

    public function store(Request $request){
        return Position::create([
            'name' => $request->name
        ]);
    }

    public function update($id, Request $request){
        $type = Position::find($id);
        $type->name = $request->name;
        $type->save();
        return $type;
    }

    public function destroy($id){
        UserPositions::where('position_id', $id)->delete;
        Subscribe::where('position_id', $id)->delete;
        return Position::find($id)->delete();
    }
}
