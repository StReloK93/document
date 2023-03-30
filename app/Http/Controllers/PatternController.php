<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;
use App\Models\PatternUser;
use Auth;
class PatternController extends Controller
{
    public function index(){

        return Pattern::where('user_id', Auth::user()->id)->with(['reject'])->get();

    }

    public function show($id){

        return Pattern::where('user_id', Auth::user()->id)->with(['reject'])->where('reject_type_id', $id)->get();
        
    }


    public function store(Request $request){
        $pattern = Pattern::Create([
            'name' => $request->name,
            'reject_type_id' => $request->rejectType['id'],
            'user_id' => Auth::user()->id,
        ]);
        $arr = $this->subsArr($request->positions, $pattern);

        PatternUser::insert($arr);
        return $pattern->with(['reject'])->find($pattern->id);
    }

    public function update($id, Request $request){
        $pattern = Pattern::find($id);
        $pattern->name = $request->name;
        $pattern->reject_type_id = $request->rejectType['id'];
        $pattern->save();
        
        PatternUser::where('pattern_id', $id)->delete();
        $arr = $this->subsArr($request->positions, $pattern);
        PatternUser::insert($arr);

        return Pattern::with(['reject'])->find($id);
    }

    public function destroy($id){
        Pattern::find($id)->delete();
        PatternUser::where('pattern_id', $id)->delete();
        return true;
    }


    protected function subsArr($users, $pattern){
        $arr = [];
        foreach ($users as $key => $user) {
            $arr[] = [
                'pattern_id' => $pattern->id,
                'position_id' => $user['id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $arr;
    }
}
