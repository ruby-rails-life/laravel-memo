@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>クローバー詳細</h4>
        <a href="/clover/{{$clover->clover_name}}/edit" class="btn btn-primary">編集</a>
        <a href="/clover" class="btn btn-success">一覧に戻る</a>
        <div class="row">
          <div class="col-sm-2">
            名前
          </div>
          <div class="col-sm-10">
            {{$clover->clover_name}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            葉
          </div>
          <div class="col-sm-10">
            {{$clover->leaf_num}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            Active
          </div>
          <div class="col-sm-10">
            {{$clover->active}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            象徴
          </div>
          <div class="col-sm-10">
            {{$clover->symbol}}
          </div>
        </div>
        <hr>
        <h4>HasMany</h4>
         <a href="/relationHm/create" class="btn btn-primary">新規追加</a>
         <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clover->relationHms as $relationHm)
              <tr>
                <td>
                  {{$relationHm->name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

                <hr>
        <h4>ManyToMany</h4>
         <a href="/relationMtm/create" class="btn btn-primary">新規追加</a>
         <a href="/clover/editRelationMtm/{{$clover->clover_name}}" class="btn btn-info">編集</a>
         <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clover->relationMtms as $relationMtm)
              <tr>
                <td>
                  {{$relationMtm->name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <hr>
        <h4>HasManyThrough</h4>
         <a href="/relationHmt/create" class="btn btn-primary">新規追加</a>
         <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clover->relationHmts as $relationHmt)
              <tr>
                <td>
                  {{$relationHmt->name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>      
 
       
@stop