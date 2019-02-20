@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <p><a href="/relationHmt/create" class="btn btn-success">新規</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>HasManyThrough一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
                <th>HasMany</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationHmts as $relationHmt)
              <tr>
                <td>
                  {{$relationHmt->name}}
                </td>
                <td>
                 {{$relationHmt->relationHm->name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop