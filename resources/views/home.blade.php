@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Dashboard ViewShare:[{{$myViewKey}}] Composer:[{{$count}}]
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <div class="list-group mt-3" style="max-width: 300px;">
                        <a href="/file" target="_blank" class="list-group-item list-group-item-action"><img src="/storage/xiaoqiankun.jpg" width="100" height="100"></a>
  　　　　　                <a href="/posts" target="_blank" class="list-group-item list-group-item-action active">記事-コメント(posts)</a>
                        <a href="/photos" target="_blank" class="list-group-item list-group-item-action">画像アップロード(photos)</a>
                        <a href="/todo" target="_blank" class="list-group-item list-group-item-action">Todo</a>
                        <a href="/bmi/form" target="_blank" class="list-group-item list-group-item-action">サービス(bmi)</a>
                        <a href="/students" target="_blank" class="list-group-item list-group-item-action">Student-Courses(ManyToMany)</a>
                        @can('admin', App\User::class)
                        <a href="/user" target="_blank" class="list-group-item list-group-item-action">ユーザ一覧</a>
                        @endcan
                        <a href="/category" target="_blank" class="list-group-item list-group-item-action">Category一覧</a>
                        <a href="/clover" target="_blank" class="list-group-item list-group-item-action">クローバー一覧</a>
                        <a href="/relationHm" target="_blank" class="list-group-item list-group-item-action">HasMany一覧</a>
                        <a href="/relationMtm" target="_blank" class="list-group-item list-group-item-action">ManyToMany一覧</a>
                        <a href="/relationHmt" target="_blank" class="list-group-item list-group-item-action">HasManyThrough一覧</a>
                        <a href="/relationNullable" target="_blank" class="list-group-item list-group-item-action">0..1一覧</a>
                        <a href="/image" target="_blank" class="list-group-item list-group-item-action">Polymorphic 1:1</a>
                        <a href="/thought" target="_blank" class="list-group-item list-group-item-action">Polymorphic 1:many</a>
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
