<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clover;
use App\RelationHm;
use App\RelationMtm;
use App\Scopes\ActiveScope;

class CloverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$clovers = Clover::withTrashed()->get();
        $clovers = Clover::withTrashed()->select(['clover_name', 'deleted_at'])->withCount(['relationHms','relationHmts'])->get();

        $clovers_count = Clover::withoutGlobalScope(ActiveScope::class)->withTrashed()->count();

        //$cloves_local_scope = Clover::leaves()->orderBy('leaf_num')->get();
        $cloves_local_scope = Clover::ofLeaf(5)->get();

        $clover_has = Clover::whereHas('relationHms', function ($query) {
            $query->where('name', 'like', 'p%');
        },'>=', 2)->get();
        $clover_has_through = Clover::has('relationHmts')->get();

        return view('clover.index', [
            'clovers' => $clovers, 
            'clovers_count' => $clovers_count, 
            'cloves_local_scope' => $cloves_local_scope,
            'clover_has' => $clover_has,
            'clover_has_through' => $clover_has_through
        ]
        );
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
        $clover = new Clover;
        $clover->clover_name = $request->clover_name;
        $clover->symbol = $request->symbol;
        $clover->leaf_num = intval($request->leaf_num);
        $clover->save();
 
        // $clover = \App\Clover::firstOrCreate(
        //     ['clover_name' => $request->clover_name], 
        //     ['symbol' => $request->symbol],
        //     ['leaf_num' => intval($request->leaf_num)]
        // );
        return redirect('/clover');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $clover_name
     * @return \Illuminate\Http\Response
     */
    public function show($clover_name)
    {
        $clover = Clover::withTrashed()->find($clover_name);
        $clover->loadMissing(['relationHms' => function ($query) {
                $query->orderBy('name', 'asc');
            },
            'relationHmts' => function ($query) {
                $query->orderBy('name', 'asc');
            },
            'relationMtms' => function ($query) {
                $query->orderBy('name', 'asc');
            }
        ]);
        return view('clover.show', ['clover' => $clover]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $clover_name
     * @return \Illuminate\Http\Response
     */
    public function edit($clover_name)
    {
        $clover = Clover::withTrashed()->find($clover_name);
        return view('clover.edit', ['clover' => $clover]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clover_name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $clover_name)
    {
        $clover = Clover::withTrashed()->find($clover_name);
        $clover->symbol = $request->symbol;
        $clover->active = $request->active;
        $clover->leaf_num = $request->leaf_num;
        $clover->save();
 
        return redirect('/clover');
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

    public function editRelationMtm($clover_name)
    {
        $clover = Clover::withTrashed()->find($clover_name);
        $relationMtms = RelationMtm::all();

        $cloverRelationMtmIds = $clover->RelationMtms()->pluck('id');

        return view('clover.editRelationMtm', ['clover' => $clover, 
            'relationMtms'=> $relationMtms,
            'cloverRelationMtmIds' => $cloverRelationMtmIds
        ]);
    }

    public function updateRelationMtm(Request $request, $clover_name)
    {
        $clover = Clover::withTrashed()->find($clover_name);
        $existRelationMtms = collect($clover->relationMtms()->pluck('id'));
        $newRelationMtms = collect(request()->relationMtms);
        $addRelationMtms = $newRelationMtms->diff($existRelationMtms);
        $deleteRelationMtms = $existRelationMtms->diff($newRelationMtms);
        $clover->relationMtms()->detach($deleteRelationMtms);
        $clover->relationMtms()->attach($addRelationMtms);
        return redirect('/clover/'. $clover_name);
    }
}
