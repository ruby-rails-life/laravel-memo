<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function index(Request $request) {
        #キーワード受け取り
        $keyword = $request->input('keyword');
        
        #クエリ生成
        $query = Article::query();
 
        #キーワードがある場合
        if(!empty($keyword))
        {
            $query->where('title','like',"%$keyword%");
        }
        
        #ページネーション
        $articles = $query->orderBy('created_at','desc')->paginate(2);
        return view('article.index')->with('articles',$articles)->with('keyword',$keyword);
        //return view('article.index', ['articles' => $articles, 'keyword' => $keyword]);
    }

    //jsonを返す
    public function json()
    {
        $query = Article::query();

        $articles = $query->orderBy('created_at','desc')->paginate(5);
        return \Response::json($articles);
    }

    //ajaxでページネート
    public function ajax(Request $request)
    {
        $page = $request->input('page');
        if(empty($page)) $page = 1;

        return view('article.ajax')->with('page',$page);
    }


    public function create() {
        return view('article.create');
    }
 
    public function store(Request $request) {
        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();
 
        return view('article.store');
    }

    public function edit(Request $request, $id) {
        $article = Article::find($id);
        return view('article.edit', ['article' => $article]);
    }
 
    public function update(Request $request) {
        $article = Article::find($request->id);
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();
 
        return view('article.update');
    }

    public function show(Request $request, $id) {
        $article = Article::find($id);
        return view('article.show', ['article' => $article]);
    }
 
    public function delete(Request $request) {
        Article::destroy($request->id);
        return view('article.delete');
    }
}
