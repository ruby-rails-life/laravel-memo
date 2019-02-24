<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Events\PostCreated;
use Validator;
use App\Jobs\ProcessPost;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $posts = Post::all();
      //$posts = Post::where('user_id',1)->get();
      return view('board.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin', Post::class);
        return view('board.create');
        
        // if (Auth::user()->can('admin', Post::class)) {
        //     // 関連するポリシーの"create"メソッドが実行される
        //     return view('board.create');
        // }
        // else{
        //     return 'You can not access';
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
        'title' => 'required|kana',
        'content'=>'required',
        'category_id' => 'required',
      ];

      // $messages = array(
      //   'title.required' => 'タイトルを正しく入力してください。',
      //   'content.required' => '本文を正しく入力してください。',
      //   'category_id.required' => 'カテゴリーを選択してください。',
      // );

      //$validator = Validator::make($request->all(), $rules, $messages);
      $validator = Validator::make($request->all(), $rules);

      if ($validator->passes()) {
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->comment_count = 0;
        $post->user_id = Auth::user()->id;
        $post->save();

        event(new PostCreated($post));

        return redirect('/posts/create')
          ->with('message', '投稿が完了しました。');
      }else{
        return redirect('/posts/create')
          ->withErrors($validator)
          ->withInput();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (Gate::allows('board.single', $post)) {
            // 現在のユーザーはこのポストを更新できる
            return view('board.single',['post' => $post]);
        }
        else{
            return 'You can not access';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('board.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
      $rules = [
        'title' => 'required',
        'content'=>'required',
        'category_id' => 'required',
      ];

      $messages = array(
        'title.required' => 'タイトルを正しく入力してください。',
        'content.required' => '本文を正しく入力してください。',
        'category_id.required' => 'カテゴリーを選択してください。',
      );

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->passes()) {
        $post = Post::find($post->id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->save();

        //ProcessPost::dispatch($post);
        //遅延ディスパッチ
         ProcessPost::dispatch($post)
                 ->delay(now()->addMinutes(3))->onConnection('database');
        
        //ジョブはキューされずに現在のプロセスで即時実行
        //ProcessPost::dispatchNow($post);

        return redirect('/posts')
          ->with('message', '投稿が完了しました。');
      }else{
        // return redirect('/posts/' .$post->id.'/edit')
        //   ->withErrors($validator)
        //   ->withInput();
        return back()->withErrors($validator)->withInput();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
