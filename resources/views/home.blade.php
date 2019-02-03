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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
