<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManyToMany;

class ManyToManyController extends Controller
{
    public function index()
    {
        $manyToManies = ManyToMany::all();
        return view('manyToMany.index')->with(['manyToManies' => $manyToManies]);
    }
    
    public function create()
    {
        return view('manyToMany.create');
    }

    public function store(Request $request) {
        $manyToMany = new ManyToMany;
        $manyToMany->name = $request->name;
        $manyToMany->save();

        return redirect('/manyToMany');
    }
}
