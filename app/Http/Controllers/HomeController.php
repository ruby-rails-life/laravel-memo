<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $encrypted = Crypt::encryptString('Hello world.');
        $decrypted = Crypt::decryptString($encrypted);
        $bcrypt = Hash::make('Hello');
        if (Hash::needsRehash($bcrypt)) {
            $bcrypt = Hash::make('Hello-World');
        }

        $userReq = $request->user();

        //$redis_name = Redis::get('redis-name');

        return view('home',['userReq' => $userReq, 
            'decrypted' => $decrypted, 
            'bcrypt'=> $bcrypt,
            //'redis_name' => $redis_name
        ]);
    }
}
