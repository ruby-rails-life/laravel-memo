@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>HasManyThrouygh</h4>
        <form method="post" action="/relationHmt" enctype="multipart/form-data">
           {{ csrf_field() }}
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <select name="relation_hm_id">
            @foreach($relationHms as $id => $name)
            <option value="{{ $id}}">{{$name}}</option>
            @endforeach
          </select>
          <div class="form-group">
            <label for="image">画像</label>
            <input type="file" id="image" name="image">
          </div>
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
      </div>
    </div>
@stop