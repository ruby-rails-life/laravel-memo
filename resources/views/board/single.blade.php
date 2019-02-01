@extends('layouts.default')
@section('content')

@if(session('message'))
    <div class="bg-info">
        <p>{{ session('message') }}</p>
    </div>
@endif

{{-- エラーメッセージの表示 --}}
@foreach($errors->all() as $message)
    <p class="bg-danger">{{ $message }}</p>
@endforeach

<div class="col-xs-8 col-xs-offset-2">

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h2>タイトル：{{ $post->title }}</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <a class="btn btn-sm btn-outline-secondary">カテゴリー：{{ $post->category->name }}</a>
            </div>
            <small class="text-muted">{{date("Y年 m月 d日",strtotime($post->created_at))}}</small>
        </div>
    </div>
</div>
<p>{{ $post->content }}</p>

<hr />

<h3>コメント一覧</h3>
@foreach($post->comments as $single_comment)
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4>{{ $single_comment->commenter }}</h4>
            <div class="d-flex justify-content-between align-items-center">
                <p>{{ $single_comment->comment }}</p>
                <small class="text-muted">{{date("Y年 m月 d日",strtotime($single_comment->created_at))}}</small>
            </div>
        </div>
    </div>
@endforeach
@stop