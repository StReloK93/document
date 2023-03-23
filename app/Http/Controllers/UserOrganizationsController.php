<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\UserOrganizations;
class UserOrganizationsController extends Controller
{

    public function update(Request $request){

        return UserOrganizations::create([
            'user_id' => $request->user_id,
            'organization_id' => $request->id,
        ]);

    }


    public function destroy(Request $request){

        return UserOrganizations::where([
            'user_id' => $request->user_id,
            'organization_id' => $request->id,
        ])->delete();

    }

}
