<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container">
      <a class="navbar-brand" href="{{url('/project')}}">MyProj</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownProject" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              プロジェクト管理
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownProject">
              <a class="dropdown-item" href="/project">プロジェクト検索</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/project/csv_index">CSVインポート</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/project/excel_index">EXCELインポート</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownVuejs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Vue.js
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownVuejs">
              <a class="dropdown-item" href="{{ url('/todo-component') }}">Todo-Component</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ url('/invoices') }}">Invoices</a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a id="navbarDropdownRight" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownRight">
              <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul> 
      </div>
    </div>
    </nav>
    
    <main role="main" class="container" style="margin-top:80px;">
      <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>
      </div>
    </main>
  </div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    @yield('script')
</body>
</html>
