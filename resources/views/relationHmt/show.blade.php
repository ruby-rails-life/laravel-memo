@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>HanManyThrough詳細</h4>
        <a href="/relationHmt" class="btn btn-success">一覧に戻る</a>
        <div class="row">
          <div class="col-sm-2">
            名前
          </div>
          <div class="col-sm-10">
            {{$relationHmt->name}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            画像
          </div>
          <div class="col-sm-10">
            @if($relationHmt->image)
            <img src="{{$relationHmt->image->name}}">
            @endif
          </div>
        </div>

        <hr>
        <h4>Thoughts新規追加</h4>
        <form method="post" action="/relationHmt/createThought/{{$relationHmt->id}}">
           {{ csrf_field() }}
          <div class="form-group">
            <label for="content"></label>
            <textarea class="form-control" id="content" rows="3" name="content"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">新規追加</button>
        </form>
<hr>
        <h4>Thoughts一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>Content</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationHmt->thoughts as $thought)
              <tr>
                <td>
                  {{$thought->content}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>      
 
       
@stop