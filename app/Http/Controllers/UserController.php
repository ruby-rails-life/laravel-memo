<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request) {
        
        $this->authorize('admin', User::class);
        $users = DB::table('users')->get();

        $roles = DB::table('users')->pluck('role', 'name');

        $arr_name_email = [];
        DB::table('users')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $arr_name_email[] = $user->name . ':' . $user->email; 
                var_dump($arr_name_email);
            }
        });

        $user_count = DB::table('users')->count();
        $admin_exists = DB::table('users')->where('name', 'admin')->exists();

        $role_count = DB::table('users')
                     ->select(DB::raw('count(*) as role_count, role'))
                     ->groupBy('role')
                     ->get();

        $user_posts = DB::table('users')
        ->join('posts', function ($join) {
            $join->on('users.id', '=', 'posts.user_id')
                 ->where('posts.user_id', '=', Auth::User()->id);
        })
        ->get();

        $first = DB::table('users')
            ->where('name','admin');

        $user_unions = DB::table('users')
            ->where('role',1)
            ->union($first)
            ->get();

        $users_arrwhere = DB::table('users')->where([
            ['name', '=', 'admin'],
            ['role', '=', 1],
        ])->get();


        $users_wherein = DB::table('users')
                    ->whereIn('role', [1, 2])
                    ->get();


        $users_wherecolumn = DB::table('users')
                ->whereColumn('updated_at', '=', 'created_at')
                ->get();

        $users_whereExists = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('posts')
                      ->whereRaw('posts.user_id = users.id');
            })
            ->get();

        $randomUser = DB::table('users')
                ->inRandomOrder()
                ->first();    


         $input_role = $request->input('role');
         $users_when = DB::table('users')
                ->when($input_role, function ($query, $role) {
                    return $query->where('role', $role);
                })
                ->get();       


         DB::table('users')
            ->where('id', 1)
            ->update(['role' => 2]);       

        return view('user.index', ['users' => $users, 
        	'roles' => $roles,
        	'user_count' => $user_count,
            'admin_exists' => $admin_exists,
            'role_count' => $role_count, 
            'user_posts' => $user_posts,
            'user_unions' => $user_unions,
            'users_arrwhere' => $users_arrwhere,
            'users_wherein' => $users_wherein,
            'users_wherecolumn' => $users_wherecolumn,
            'users_whereExists' => $users_whereExists,
            'randomUser' => $randomUser,
            'users_when' => $users_when
        ]);
    }
}
