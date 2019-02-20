@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>HanMany詳細</h4>
        <a href="/relationHm" class="btn btn-success">一覧に戻る</a>
        <div class="row">
          <div class="col-sm-2">
            名前
          </div>
          <div class="col-sm-10">
            {{$relationHm->name}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            画像
          </div>
          <div class="col-sm-10">
            @if($relationHm->image)
            <img src="{{$relationHm->image->name}}">
            @endif
          </div>
        </div>
      </div>
    </div>      
 
       
@stop