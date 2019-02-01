@extends('layouts.default')
@section('content')

<div class="col-xs-6 col-xs-offset-2">

<h1>投稿ページ</h1>
@if(session('message'))
 <div class="bg-info">
  <p>{{ session('message') }}</p>
</div>
@endif
@foreach($errors->all() as $message)
 <p class="bg-danger">{{ $message }}</p>
@endforeach
<form method="POST" action="/posts">
 @csrf
  <div class="form-group">
   <label for="title" class="">タイトル</label>
   <div class="">
    <input type="text" class="col-sm-12" name="title">
   </div>
  </div>
  <div class="form-group">
   <label for="category_id" class="">カテゴリー</label>
   <div class="">
    <select name="category_id" type="text" class="">
     <option></option>
     <option value="1" name="1">カテゴリーその１</option>
     <option value="2" name="2">カテゴリーその２</option>
    </select>
   </div>
  </div>
  <div class="form-group">
   <label for="content" class="">本文</label>
    <div class="">
     <textarea class="col-sm-12" name="content"></textarea>
    </div>
   </div>
   <div class="form-group">
    <button type="submit" class="btn btn-primary">投稿する</button>
   </div>
</form>
<a href="/posts" class="btn btn-success">一覧に戻る</a>
</div>

@stop