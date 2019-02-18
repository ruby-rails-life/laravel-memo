@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>クローバー新規追加</h4>
        <form method="post" action="/clover">
           {{ csrf_field() }}
          <div class="form-group">
            <label for="clover_name">名前</label>
            <input type="text" class="form-control" id="clover_name" name="clover_name">
          </div>
          <div class="form-group">
            <label for="symbol"></label>
            <textarea class="form-control" id="symbol" rows="3" name="symbol"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
      </div>
    </div>
@stop