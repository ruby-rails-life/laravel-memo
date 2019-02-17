@extends('layouts.default')
@section('content')

@can('admin', App\Post::class)
<div class="col-xs-12">
    <p><a href="/posts/create" class="btn btn-success">投稿</a></p> 
</div>    
@endcan
<div class="col-xs-8 col-xs-offset-2">
@foreach($posts as $post)

    <h2>タイトル：{{ $post->title }}
        <small>投稿日：{{ date("Y年 m月 d日",strtotime($post->created_at)) }}</small>
    </h2>
    <p>カテゴリー：{{ $post->category->name }}</p>
    <p>{{ $post->content }}</p>
    <p><a href="/posts/{{$post->id}}" class="btn btn-primary">続きを読む</a></p>
    <p>コメント数：{{ $post->comment_count }}</p>
    <hr />
@endforeach

</div>

@stop