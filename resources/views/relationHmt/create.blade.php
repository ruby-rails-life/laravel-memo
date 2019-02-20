@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>HasManyThrouygh</h4>
        <form method="post" action="/relationHmt">
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
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
      </div>
    </div>
@stop