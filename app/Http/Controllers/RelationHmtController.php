<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelationHmt;
use App\RelationHm;

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

        return redirect('/relationHmt');
    }
}
