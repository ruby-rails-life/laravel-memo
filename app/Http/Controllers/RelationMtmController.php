<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelationMtm;
use App\Http\Resources\RelationMtm as RelMtmResource;

class RelationMtmController extends Controller
{
    public function index()
    {
        $relationMtms = RelationMtm::all();
        return view('relationMtm.index')->with(['relationMtms' => $relationMtms]);
    }
    
    public function create()
    {
        return view('relationMtm.create');
    }

    public function store(Request $request) {
        $relationMtm = new RelationMtm;
        $relationMtm->name = $request->name;
        $relationMtm->save();

        return redirect('/relationMtm');
    }

    public function show($id)
    {
        $relationMtm = RelationMtm::find($id);
        return view('relationMtm.show', ['relationMtm' => $relationMtm]);
    }

    public function relationMtm_res()
    {
        $relationMtm = RelationMtm::find(3);
        $relationMtm->loadMissing('relationNullables');
        return new RelMtmResource($relationMtm);
    }
}
