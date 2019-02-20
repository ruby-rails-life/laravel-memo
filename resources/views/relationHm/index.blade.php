@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <p><a href="/relationHm/create" class="btn btn-success">新規</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>HasMany一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
                <th>クローバー</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationHms as $relationHm)
              <tr>
                <td>
                  {{$relationHm->name}}
                </td>
                <td>
                  {{$relationHm->clover->clover_name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop