<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelationHmt;
use App\RelationHm;
use Intervention\Image\Facades\Image;

class RelationHmtController extends Controller
{
    public function index()
    {
        $relationHmts = RelationHmt::orderBy('relation_hm_id')->get();
        return view('relationHmt.index')->with(['relationHmts' => $relationHmts]);
    }
    
    public function create()
    {
        //取得コレクションのキーカラムを指定することもできます。
        $relationHms = RelationHm::orderBy('id','asc')->pluck('name','id');
        return view('relationHmt.create')->with(['relationHms' => $relationHms]);
    }

    public function store(Request $request) {
        $relationHmt = new RelationHmt;
        $relationHmt->name = $request->name;
        $relationHmt->relation_hm_id = $request->relation_hm_id;
        $relationHmt->save();

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
        $relationHmt->image()->create(['name' => $path]);

        return redirect('/relationHmt');
    }

    public function show($id)
    {
        $relationHmt = RelationHmt::find($id);
        return view('relationHmt.show', ['relationHmt' => $relationHmt]);
    }
}
