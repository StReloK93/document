<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOrganizations;
use App\Models\UserPositions;
use App\Models\UserRolls;
use Validator;
use Hash;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function update(Request $request){
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->save();

        return $user;
    }

    public function passwordClear(Request $req){
        $user = User::find($req->id);
        $user->password = Hash::make('zzzz1111*');
        $user->save();
    }

    public function addUser(Request $request){

        $validate = Validator::make($request->all(),[
            'login' => 'required|unique:users',
        ],$messages = [
            'required' => ":attribute bo'sh bo'lmasligi kerak",
            'unique' => ":attribute band",
            'login' => ":attribute to'gri emas",
        ],[
            'login' => "Login",
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),299);
        }

        $organizations = [];
        $positions = [];
        $rolls = [];

        $request->organizations;
        $request->positions;
        $request->rolls;

        $user = User::create([
            'name' => $request->name,
            'login' => $request->login,
            'password' => Hash::make('zzzz1111*'),
        ]);

        foreach ($request->organizations as $key => $value) {
            $organizations[] = [
                'user_id' => $user->id,
                'organization_id' => $value['id'],
                'created_at' => now(),
            ];
        }
        UserOrganizations::insert($organizations);

        foreach ($request->positions as $key => $value) {
            $positions[] = [
                'user_id' => $user->id,
                'position_id' => $value['id'],
                'created_at' => now(),
            ];
        }
        UserPositions::insert($positions);

        foreach ($request->rolls as $key => $value) {
            $rolls[] = [
                'user_id' => $user->id,
                'roll_id' => $value['id'],
                'created_at' => now(),
            ];
        }
        UserRolls::insert($rolls);

        return User::find($user->id);
    }
}
