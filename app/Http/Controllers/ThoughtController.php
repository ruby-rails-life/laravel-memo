<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thought;

class ThoughtController extends Controller
{
    public function index()
    {
      $thoughts = Thought::all();
      return view('thought.index', ['thoughts' => $thoughts]);
    }
}
