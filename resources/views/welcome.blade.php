<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <h2>{{$locale}} {{session('mySessionKey')}}</h2>
                <table>
                    <tr>
                        <td>
                            Custom Directive        
                        </td>
                        <td>
                            @datetime(new DateTime())
                        </td>
                    </tr>
                    <tr>
                        <td>
                            message1
                        </td>
                        <td>
                        {{ __('messages.welcome1')}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            message2
                        </td>
                        <td>
                        @lang('messages.welcome2', ['name' => 'angel'])
                        </td>
                    </tr>
                    <tr>
                        <td>
                            goodbye
                        </td>
                        <td>
                        @lang('messages.goodbye', ['name' => 'angel'])
                        </td>
                    </tr>
                    <tr>
                        <td>
                            trans_choice:apples
                        </td>
                        <td>
                        {{trans_choice('messages.apples', 10)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            trans_choice:minutes_ago
                        </td>
                        <td>
                        {{trans_choice('messages.minutes_ago', 5, ['value' => 5])}}
                        </td>
                    </tr>
                     <tr>
                        <td>
                            trans_choice:oranges :count
                        </td>
                        <td>
                        {{trans_choice('messages.oranges', 5)}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
