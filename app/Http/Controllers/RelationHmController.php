<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clover;
use App\RelationHm;
use Intervention\Image\Facades\Image;

class RelationHmController extends Controller
{
    
    public function index()
    {
        $relationHms = RelationHm::all();
        return view('relationHm.index')->with(['relationHms' => $relationHms]);
    }
    
    public function create()
    {
        $clovers = Clover::orderBy('leaf_num','asc')->pluck('clover_name');
        //$clovers = $clovers -> prepend('クローバー', '');

        return view('relationHm.create')->with(['clovers' => $clovers]);
    }

    public function store(Request $request) {
        $relationHm = new RelationHm;
        $relationHm->name = $request->name;
        $relationHm->clover_name = $request->clover_name;
        $relationHm->save();

        //画像
        $fileName = $request->image->getClientOriginalName();
        $fileName = time()."@".$fileName;
        $image = Image::make($request->image->getRealPath());
 
        //画像リサイズ ※追加
        $image->resize(100, null, function ($constraint) {
              $constraint->aspectRatio();
        });
 
        $image->save(public_path() . '/images/' . $fileName);
        $path = '/images/' . $fileName;
        $relationHm->image()->create(['name' => $path]);

        return redirect('/relationHm');
    }

    public function show($id)
    {
        $relationHm = RelationHm::find($id);
        return view('relationHm.show', ['relationHm' => $relationHm]);
    }

    public function createThought(Request $request,$id) {
        $relationHm = RelationHm::find($id);
        $relationHm->thoughts()->create(['content' => $request->content]);

        return redirect('/relationHm/' . $id);
    }
}
