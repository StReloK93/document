<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backup;
class BackupController extends Controller
{
    public function add($document_id, Request $request){
        return Backup::create([
            'document_id' => $document_id,
            'description' => $request->description,
        ]);
    }

    public function remove($id){
        return Backup::find($id)->delete();
    }
}
