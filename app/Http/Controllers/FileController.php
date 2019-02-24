<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\MyException;

class FileController extends Controller
{
    public function index()
    {
        //report(new MyException('My Exception***')); ;
        //throw new MyException('My Exception***');
        //abort(333);

        $fileName = 'xiaoqiankun.jpg';
    	// //return Storage::get($fileName);
    	$data = [];
    	$size =Storage::disk('public')->size($fileName); 
    	$url = Storage::disk('public')->url($fileName);
    	$data['size'] = $size;
    	$data['url'] = $url;
    	return $data;

        //return response()->file(public_path() . '/storage/'. $fileName);
        //return response()->download(public_path() . '/storage/'. $fileName);


    	// if (Storage::exists($fileName))
    	// {
    	//     return Storage::download($fileName);
    	// }
    	// else
    	// {
    	//     return Storage::disk('public')->download($fileName);
    	// }
    }
}
