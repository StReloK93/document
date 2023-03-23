<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Auth;
use DB;
class OrganizationController extends Controller
{
    public function index(){
        return response()->json([
            'organizations' =>  DB::connection('tatil')->table('organizations')->get(),
            'issets' => Organization::where('bool', true)->pluck('id')->toArray(),
        ]);
    }

    public function all(){
        
        $array = Organization::where('bool', true)->pluck('id')->toArray();
        return DB::connection('tatil')->table('organizations')->whereIn('id', $array)->get();
    }

    public function my(){
        $array = Auth::user()->organizations->pluck('organization_id')->toArray();
        $array = Organization::where('bool', true)->whereIn('id', $array)->pluck('id')->toArray();
        return DB::connection('tatil')->table('organizations')->whereIn('id', $array)->get();
    }

    public function update($id){
        $organ = Organization::find($id);
        $organ->bool = true;
        $organ->save();
        return  $organ;
    }

    public function destroy($id){
        $organ = Organization::find($id);
        $organ->bool = false;
        $organ->save();
        return  $organ;
    }
}
