<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelationNullable;
use App\relationMtm;

class RelationNullableController extends Controller
{
    public function index()
    {
        $relationNullables = RelationNullable::all();
        return view('relationNullable.index')->with(['relationNullables' => $relationNullables]);
    }
    
    public function create()
    {
        $relationMtms = relationMtm::orderBy('name','asc')->pluck('name','id');
        $relationMtms = $relationMtms -> prepend('RelationMtm', '');
        return view('relationNullable.create')->with(['relationMtms' => $relationMtms]);
    }

    public function store(Request $request) {
        $relationNullable = new RelationNullable;
        $relationNullable->name = $request->name;
        $relationNullable->relation_mtm_id = $request->relation_mtm_id;
        $relationNullable->save();
        return redirect('/relationNullable');
    }

    public function show($id)
    {
        $relationNullable = RelationNullable::find($id);
        return view('relationNullable.show', ['relationNullable' => $relationNullable]);
    }

    public function dissociate($id)
    {
        $relationNullable = RelationNullable::find($id);
        $relationNullable->relationMtm()->dissociate();
        $relationNullable->save();

        return redirect('/relationNullable');
    }

    public function edit($id)
    {
        $relationNullable = RelationNullable::find($id);
        $relationMtms = relationMtm::orderBy('name','asc')->pluck('name','id');
        $relationMtms = $relationMtms -> prepend('RelationMtm', '');
        return view('relationNullable.edit')->with(['relationMtms' => $relationMtms, 
            'relationNullable'=> $relationNullable]);
    }

    public function update(Request $request, $id)
    {
        $relationNullable = RelationNullable::find($id);
        $relationNullable->name = $request->name;
        $relationNullable->relation_mtm_id = $request->relation_mtm_id;
        $relationNullable->save();
 
        return redirect('/relationNullable');
    }
}
