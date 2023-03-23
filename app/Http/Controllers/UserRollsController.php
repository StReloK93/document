<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRolls;
class UserRollsController extends Controller
{
    public function update(Request $request){

        return UserRolls::create([
            'user_id' => $request->user_id,
            'roll_id' => $request->id,
        ]);

    }


    public function destroy(Request $request){

        return UserRolls::where([
            'user_id' => $request->user_id,
            'roll_id' => $request->id,
        ])->delete();

    }
}
