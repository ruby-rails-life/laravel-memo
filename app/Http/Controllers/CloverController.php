<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clover;

class CloverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clovers = Clover::withTrashed()->get();

        return view('clover.index', ['clovers' => $clovers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clover.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // $clover = new Clover;
        // $clover->clover_name = $request->clover_name;
        // $clover->symbol = $request->symbol;
        // $clover->save();
 
        $clover = \App\Clover::firstOrCreate(
            ['clover_name' => $request->clover_name], ['symbol' => $request->symbol]
        );
        return redirect('/clover');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $clover_name
     * @return \Illuminate\Http\Response
     */
    public function destroy($clover_name)
    {
        Clover::destroy($clover_name);

        return redirect('/clover');
    }

    public function restore($clover_name)
    {
       Clover::withTrashed()
        ->where('clover_name', $clover_name)
        ->restore();

       return redirect('/clover');
    }

    public function delete($clover_name)
    {
       Clover::withTrashed()
        ->where('clover_name', $clover_name)
        ->forceDelete();

       return redirect('/clover');
    }

}
