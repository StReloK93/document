<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserPositions;

class UserPositionsController extends Controller
{
    public function update(Request $request){

        return UserPositions::create([
            'user_id' => $request->user_id,
            'position_id' => $request->id,
        ]);

    }


    public function destroy(Request $request){

        return UserPositions::where([
            'user_id' => $request->user_id,
            'position_id' => $request->id,
        ])->delete();

    }
}
