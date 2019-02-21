@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>HasMany</h4>
        <form method="post" action="/relationHm" enctype="multipart/form-data">
           {{ csrf_field() }}
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="clover_name">Clover</label>
            <select id="clover_name" name="clover_name" class="form-control">
              @foreach($clovers as $clover)
              <option value="{{ $clover}}">{{$clover}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="category_ids">Category</label>
            <select id="category_ids" name="categories[]" class="form-control" multiple>
              @foreach($categories as $id => $name)
              <option value="{{ $id}}">{{$name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="image">画像</label>
            <input type="file" id="image" name="image">
          </div>
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
      </div>
    </div>
@stop