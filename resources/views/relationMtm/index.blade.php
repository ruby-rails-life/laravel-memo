@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <p><a href="/relationMtm/create" class="btn btn-success">新規</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>ManyToMany一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationMtms as $relationMtm)
              <tr>
                <td>
                  <a href="/relationMtm/{{$relationMtm->id}}">{{$relationMtm->name}}</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop