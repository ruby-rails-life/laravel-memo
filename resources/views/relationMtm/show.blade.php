@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>ManyToMany詳細</h4>
        <a href="/relationMtm" class="btn btn-success">一覧に戻る</a>
        <div class="row">
          <div class="col-sm-2">
            名前
          </div>
          <div class="col-sm-10">
            {{$relationMtm->name}}
          </div>
        </div>
        
<hr>
        <h4>Categories一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>name</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationMtm->categories as $category)
              <tr>
                <td>
                  {{$category->name}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>      
 
       
@stop