<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiCalController extends Controller
{
    public function getIndex() 
    {
        return view('bmi.form');
    }

    public function result(Request $request)
    {
        $validateRules = [
            'weight'=>'required|numeric',
            'height'=>'required|numeric'
        ];
 
        $validateMessages = [
            "required" => "必須項目です。",
            "numeric" => "数値で入力してください。"
        ];
 
        $this->validate($request, $validateRules, $validateMessages);

        $weight = $request->input('weight');
        $height = $request->input('height');
 
        $hash = array(
            'weight' => $weight,
            'height' => $height,
        );
 
        return view('bmi.result')->with($hash);
    }
}
