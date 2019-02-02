@extends('layouts.default_bmi')
@section('title', '結果画面｜BMI')
@section('content')
  <div class="jumbotron">
  <h1>BMI計算</h1>
  <p>BMI 計算を自動でいたします。ダイエットにお役立てください。</p>
  <p>BMI＝体重(kg) ÷ {身長(m) Ｘ 身長(m)}</p>
  </div>
 
  <p>あなたのBMIは <span style="color:tomato; font-size:24px; font-weight:bold;">{{ BmiCal::cal($height,$weight) }}</span> です。</p>
  <p>判定は <span style="color:tomato; font-size:24px; font-weight:bold;">{{ BmiCal::hantei($height,$weight) }}</span> です。</p>
  <br>
 
  <a href="{{ route('bmi.form') }}"><button class="btn btn-default">戻る</button></a>
@endsection