<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!-- オプションのテーマ -->
<style>
</style>
</head>
 
<body>
 
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
  <div class="navbar-header">
  <a class="navbar-brand" href="/photos/create">ファイルアップロード機能</a>
  </div>
  <div id="navbar" class="collapse navbar-collapse">
  </div><!--/.nav-collapse -->
  </div>
</nav>
 
<div class="container" style="margin-top: 30px;">
<h2>@yield('title')</h2>
@yield('content')
</div><!-- /container -->
</body>
</html>