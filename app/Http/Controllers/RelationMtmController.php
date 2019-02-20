<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelationMtm;

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
}
