@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>クローバー編集</h4>
        <form method="post" action="/clover/{{$clover->clover_name}}">
           {{ csrf_field() }}
           <input type="hidden" name="_method" value="PUT">
          <div class="form-group">
            <span>{{$clover->clover_name}}</span>
          </div>  
          <div class="form-check">
  　　　　　　　　　<input class="form-check-input" type="radio" name="active" id="active1" value="1" @if ($clover->active == 1) checked @endif>
             <label class="form-check-label" for="active1">
               Active
             </label>
          </div>
          <div class="form-check">
  　　　　　　　　　<input class="form-check-input" type="radio" name="active" id="active2" value="0" @if ($clover->active == 0) checked @endif>
             <label class="form-check-label" for="active2">
               Disabled
             </label>
          </div>
          <div class="form-group">
            <label for="leaf_num">葉</label>
            <input type="text" class="form-control" id="leaf_num" name="leaf_num">
          </div>
          <div class="form-group">
            <label for="symbol">象徴</label>
            <textarea class="form-control" id="symbol" rows="3" name="symbol" value="{{$clover->symbol}}"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">保存</button>
        </form>
      </div>
    </div>
@stop