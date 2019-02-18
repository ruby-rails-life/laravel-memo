@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <div class="list-group mt-3" style="max-width: 300px;">
  　　　　　                <a href="/posts" target="_blank" class="list-group-item list-group-item-action active">記事-コメント(posts)</a>
                        <a href="/photos" target="_blank" class="list-group-item list-group-item-action">画像アップロード(photos)</a>
                        <a href="/bmi/form" target="_blank" class="list-group-item list-group-item-action">サービス(bmi)</a>
                        <a href="/students" target="_blank" class="list-group-item list-group-item-action">Student-Courses(ManyToMany)</a>
                        @can('admin', App\User::class)
                        <a href="/user" target="_blank" class="list-group-item list-group-item-action">ユーザ一覧</a>
                        @endcan
                        <a href="/clover" target="_blank" class="list-group-item list-group-item-action">クローバー一覧</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <table>
                <tr>
                    <td>
                    user from request:{{$userReq->name}}
                    </td>
                </tr>
                <tr>     
                    <td>
                    user checked?:{{Auth::check()}}    
                    </td>   
                </tr>
                <tr>
                    <td>
                    viaRemember?:{{Auth::viaRemember()}}
                    </td>
                </tr>
                <tr>    
                    <td>
                    decrypted:{{$decrypted}}
                    </td>    
                </tr>
                <tr>    
                    <td>
                    bcrypt:{{$bcrypt}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Hash::check:{{Hash::check('Hello', $bcrypt)}}
                    </td>    
                </tr>       
            </table>    
        </div>
    </div>
</div>
@endsection
