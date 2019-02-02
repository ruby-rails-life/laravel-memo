@extends('layouts.article')
@section('content')

    <!--↓↓ 検索フォーム ↓↓-->
    <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
      <form class="form-inline" action="{{url('/')}}">
        <div class="form-group">
          <input type="text" name="keyword" value="{{$keyword}}" class="form-control" placeholder="タイトルを入力してください">
        </div>
        <input type="submit" value="検索" class="btn btn-info">
      </form>
    </div>
    <!--↑↑ 検索フォーム ↑↑-->

    <h4>ブログ一覧</h4>
 
    @foreach ($articles as $article)
    <div class="card mb-2">
      <div class="card-body">
        <h4 class="card-title">{{ $article->title }}</h4>
        <h6 class="card-subtitle mb-2 text-muted">{{ $article->updated_at }}</h6>
        <p class="card-text">{{ $article->body }}</p>
        <a href="/edit/{{ $article->id }}" class="card-link">修正</a>
        <a href="/delete/{{ $article->id }}" class="card-link">削除</a>
      </div>
    </div>
    @endforeach
 
    <div class="col-sm-8" style="text-align:right;">
      <div class="paginate">
        {{ $articles->appends(Request::only('keyword'))->links() }}
      </div>
    </div>
@stop