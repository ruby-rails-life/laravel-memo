@extends('layouts.default_photos')
@section('title', 'ファイルアップロード機能')
@section('content')
 
@if (session('status'))
<div class="alert alert-success" role="alert" onclick="this.classList.add('hidden')">{{ session('status') }}</div>
@endif

<form method="post" action="{{ action('PhotosController@store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <fieldset>
            <div>
                <input id="file" type="file" name="fileName">

                @if ($errors->has('fileName'))
                    {{ $errors->first('fileName') }}
                @endif
            </div>
        </fieldset>

        <input type="submit" value="アップロード">
    </form>
 
<hr color="#000000" style="height:1px;">

@foreach ($photos as $photo)
<div class="panel panel-default">
  <div class="panel-heading">アップロードした日付：{{$photo->created_at}}</div>
  <!-- List group -->
  <ul class="list-group">
  <li class="list-group-item"><img src="{{$photo->path}}"></li>
  </ul>
</div>
@endforeach
 
@endsection