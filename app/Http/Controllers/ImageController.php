<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    public function index()
    {
      $images = Image::all();
      return view('image.index', ['images' => $images]);
    }
}
