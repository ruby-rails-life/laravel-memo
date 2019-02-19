@extends('layouts.app')
@section('content')
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <h4>{{$clover->clover_name}}のManyToMany編集</h4>
        <form method="post" action="/clover/updateManyToMany/{{$clover->clover_name}}">
           {{ csrf_field() }}
@foreach ($manyToManies as $manyToMany)
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="manyToManies[]" value="{{$manyToMany->id}}" id="{{$manyToMany->id}}" @if ($cloverManyToManyIds->contains($manyToMany->id)) checked @endif>
  <label class="form-check-label" for="{{$manyToMany->id}}">
    {{$manyToMany->name}}
  </label>
</div>
  @endforeach
                   
          <button type="submit" class="btn btn-primary">保存</button>
          <a href="/clover/{{$clover->clover_name}}" class="btn btn-success">詳細画面に戻る</a>
        </form>
      </div>
    </div>
@stop