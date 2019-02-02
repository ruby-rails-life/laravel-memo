<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiCalController extends Controller
{
    public function getIndex() {
        return view('bmi.form');
    }

    public function result(Request $request){
 
        $weight = $request->input('weight');
        $height = $request->input('height');
 
        $hash = array(
            'weight' => $weight,
            'height' => $height,
        );
 
        return view('bmi.result')->with($hash);
    }
}
