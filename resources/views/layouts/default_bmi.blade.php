<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link href="{{ url('/') }}/dist/css/vendor/bootstrap.min.css" rel="stylesheet"><!-- Loading Bootstrap -->
  <link href="{{ url('/') }}/dist/css/flat-ui.min.css" rel="stylesheet"><!-- Loading Flat UI -->
  <link rel="shortcut icon" href="{{ url('/') }}/dist/img/favicon.ico">
 
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
 
  @yield('styles')
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet"><!-- FontAwesome -->
 
</head>
<body>
 
<!--=================================================
Navbar
==================================================-->
 
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
  <!-- スマートフォンサイズで表示されるメニューボタンとテキスト -->
  <div class="navbar-header">
  <!-- タイトルなどのテキスト -->
  <a class="navbar-brand" href="#">BMI計算アプリ</a>
  </div>
  </div>
</nav>
 
<div class="container" style="margin-top: 40px;">
  @yield('content')
</div><!-- /.container -->
 
<footer class="footer">
  <div class="container">
  <p class="text-muted">BMI計算アプリ</p>
  </div>
</footer>
 
<!-- Bootstrap core JavaScript
  ================================================== -->
 <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Bootstrap 4 requires Popper.js -->
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="{{ url('/') }}/dist/scripts/flat-ui.min.js"></script>
 
@yield('scripts')
</body>
</html>