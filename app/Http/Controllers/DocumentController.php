<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Library;
use App\Models\Document;
use App\Models\Subscribe;
use App\Models\Negation;
use App\Models\Image;
use DB;
use Auth;
use File;
class DocumentController extends Controller
{
    public function positions(){
        return Auth::user()->organizations()->pluck('organization_id')->toArray();
    }

    public function index(){
        $roll = Auth::user()->rolls()->where('roll_id', 1)->exists();
        if($roll) {
            return Document::whereIn('organization_id', $this->positions())
            ->has('negation', '=' , 0)
            ->has('backup', '=' , 0)
            ->get();
        }
        return Document::whereIn('organization_id', $this->positions())
        ->forMyPositions()
        ->has('negation', '=' , 0)
        ->has('backup', '=' , 0)
        ->get();
    }

    public function negation(){
        return Document::whereIn('organization_id', $this->positions())->has('negation')->get();
    }

    public function backup(){
        return Document::whereIn('organization_id', $this->positions())->has('backup')->get();
    }

    public function show($id){
        return Document::find($id);
    }

    public function store(Request $request){

        // if($request->pdf){
        //     $imgName = Auth::user()->id . time(). $request->pdf->getClientOriginalName();
        //     $request->pdf->move('pdf',$imgName);
        // }

        $term = $request->term == 'null' ? null : $request->term;

        $doc =  Document::create([
            'name' => $request->name,
            'organization_id' => $request->organization_id,
            'reject_type_id' => $request->reject_type_id,
            'html' => $request->html,
            'user_id' => Auth::user()->id,
            // 'src' => $imgName,
            'term' => $term,
        ]);

        
        $positions = json_decode($request->positions);

        $arr = $this->subsArr($positions, $doc);
        Subscribe::insert($arr);



        if($request->images){
            $images = Library::createImages($request->images, Auth::user()->id);
            foreach ($images as $key => $image) {
                Image::create([
                    'document_id' => $doc->id,
                    'path' => $image,
                ]);
            }
        }

        return Document::find($doc->id);

    }



    
    public function update($id, Request $request){
        $doc = Document::where([
            ['id', $id],
            ['user_id', Auth::user()->id],
        ])->first();
        // Positions subscribes
        $doc->positions()->delete();
        $positions = json_decode($request->positions);
        $arr = $this->subsArr($positions, $doc);
        Subscribe::insert($arr);
        // asdasd


        // PDF
        if($request->pdf != 'null'){
            if(File::exists(public_path('/pdf/'.$doc->src))){
                File::delete(public_path('/pdf/'.$doc->src));
            }

            $imgName = Auth::user()->id . time(). $request->pdf->getClientOriginalName();
            $request->pdf->move('pdf',$imgName);

            $doc->src = $imgName;
        }
        // PDF


        // Images
        if($request->images){
            $images = Image::where('document_id', $doc->id)->whereNotIn('id', $request->images)->get();

            foreach ($images as $key => $image) {
                Library::clearImgFile($image->path);
            }
            Image::where('document_id', $doc->id)->whereNotIn('id', $request->images)->delete();
        }
        else{
            $images = Image::where('document_id', $doc->id)->get();
            foreach ($images as $key => $image) {
                Library::clearImgFile($image->path);
            }
            Image::where('document_id', $doc->id)->delete();
        }


        if($request->imgs){
            $imgs = Library::createImages($request->imgs, Auth::user()->id);
            foreach ($imgs as $key => $image) {
                Image::create([
                    'document_id' => $doc->id,
                    'path' => $image,
                ]);
            }
        }
        // Images

        $term = $request->term == 'null' ? null : $request->term;

        $doc->name = $request->name;
        $doc->html = $request->html;
        
        $doc->organization_id = $request->organization_id;
        $doc->reject_type_id = $request->reject_type_id;
        $doc->term = $term;
        $doc->save();

        return $doc->fresh();

    }





    public function destroy($id){
        $document = Document::find($id);
        if(File::exists(public_path('/pdf/'.$document->src))){
            File::delete(public_path('/pdf/'.$document->src));
        }
        foreach ($document->images as $key => $image) {
            Library::clearImgFile($image->path);
        }
        Image::where('document_id', $id)->delete();
        Negation::where('document_id', $id)->delete();
        Document::find($id)->delete();
    }


    protected function subsArr($positions, $doc){
        $arr = [];
        foreach ($positions as $key => $position) {
            $arr[] = [
                'document_id' => $doc->id,
                'position_id' => $position->id,
                'check' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $arr;
    }




    public function permonth(){
        return Document::myOrganizations()->has('negation', '=' , 0)->has('backup', '=' , 0)->get()->groupBy(function($item) {
            return (int) $item->created_at->format('m');
        });
    }

    public function perorganizations(){
        return Document::myOrganizations()->has('negation', '=' , 0)->has('backup', '=' , 0)->get()->groupBy(function($item) {
            return $item->organization->shortname;
        });
    }

    public function pertypes(){
        return Document::myOrganizations()->has('negation', '=' , 0)->has('backup', '=' , 0)->get()->groupBy(function($item) {
            return $item->reject_type->name;
        });
    }

    public function pertypesmonth(){
        return Document::myOrganizations()->has('negation', '=' , 0)->has('backup', '=' , 0)->get()->groupBy(function($item) {
            return (int) $item->created_at->format('m');
        });
    }
}
