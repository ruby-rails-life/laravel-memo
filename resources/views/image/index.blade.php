@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Polymorphic 1:1 一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>画像</th>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($images as $image)
              <tr>
                <td>
                  <img src="{{$image->name}}">
                </td>
                <td>
                  {{$image->imageable->name}}
                </td>  
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop