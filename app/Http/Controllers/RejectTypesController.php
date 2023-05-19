<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RejectTypes;
use App\Models\Pattern;
use App\Models\PatternUser;

class RejectTypesController extends Controller
{

    public function index(){
        return RejectTypes::all();
    }

    public function store(Request $request){
        return RejectTypes::create([
            'name' => $request->name,
        ]);
    }

    public function update($id, Request $request){
        $type = RejectTypes::find($id);
        $type->name = $request->name;
        $type->save();
        return $type;
    }

    public function updateHtml($id, Request $request){
        $type = RejectTypes::find($id);
        $type->html = $request->html;
        $type->save();
        return $type;
    }

    public function destroy($id){
        $patternModel = Pattern::where('reject_type_id', $id);
        $arr = $patternModel->pluck('id')->toArray();
        PatternUser::whereIn('pattern_id', $arr)->delete();
        $patternModel->delete();
        return RejectTypes::find($id)->delete();
    }

}
