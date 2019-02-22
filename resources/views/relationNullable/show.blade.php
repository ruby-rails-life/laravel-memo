@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-6">
        <h4>relationNullable詳細</h4>
        <a href="/relationNullable" class="btn btn-success">一覧に戻る</a>
        <div class="row">
          <div class="col-sm-2">
            名前
          </div>
          <div class="col-sm-10">
            {{$relationNullable->name}}
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            RelationMtm
          </div>
          <div class="col-sm-10">
            @if($relationNullable->relationMtm)
            {{$relationNullable->relationMtm->name}}
            @endif
          </div>
        </div>

      </div>
    </div>      
 
       
@stop