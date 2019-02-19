<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clover;
use App\HasMany;

class HasManyController extends Controller
{
    
    public function index()
    {
        $hasManies = HasMany::all();
        return view('hasMany.index')->with(['hasManies' => $hasManies]);
    }
    
    public function create()
    {
        $clovers = Clover::orderBy('leaf_num','asc')->pluck('clover_name');
        //$clovers = $clovers -> prepend('クローバー', '');

        return view('hasMany.create')->with(['clovers' => $clovers]);
    }

    public function store(Request $request) {
        $hasMany = new HasMany;
        $hasMany->name = $request->name;
        $hasMany->clover_name = $request->clover_name;
        $hasMany->save();

        return redirect('/hasMany');
    }
}
