@extends('layouts.default_bmi')
@section('title', '入力画面｜BMI')
@section('content')
  <div class="jumbotron">
  <h1>BMI計算</h1>
  <p>BMI 計算を自動でいたします。ダイエットにお役立てください。</p>
  <p>BMI＝体重(kg) ÷ {身長(m) Ｘ 身長(m)}</p>
  </div>
 
  <form action="{{ route('bmi.result') }}" method="post" role="form">
  {!! csrf_field() !!}
  <div class="form-group">
  <label for="InputHeight">身長(cm)</label>
  <input type="text" name="height" value="{{ old('height') }}" class="form-control" id="InputHeight" placeholder="半角英数字のみ">

  @if($errors->has('height'))<span class="error">{{ $errors->first('height') }}</span> @endif
  </div>

  <div class="form-group">
  <label for="InputWeight">体重(kg)</label>
  <input type="text" name="weight" class="form-control" id="InputWeight" placeholder="半角英数字のみ">
  </div>
  <button type="submit" class="btn btn-default">BMI計算</button>
  </form>
@endsection