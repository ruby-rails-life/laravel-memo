@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>ManyToMany</h4>
        <form method="post" action="/relationMtm">
           {{ csrf_field() }}
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
      </div>
    </div>
@stop