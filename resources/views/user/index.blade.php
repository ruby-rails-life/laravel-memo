@extends('layouts.app')
@section('content')
<div class="offset-sm-2 col-sm-8">
<h2>{{$user_count}}名 AdminExists:{{$admin_exists}} inRandomOrder:{{$randomUser->name}} </h2>

<h3>GroupBy role</h3>
@foreach($role_count as $rc)
    <h4>Role:{{$rc->role}}</h4>
    <p>Count：{{ $rc->role_count }}</p>
@endforeach
<hr/>
<h3>All of users</h3>
@foreach($users as $user)
    <h4>Name:{{$user->name}}</h4>
    <p>Email：{{ $user->email }}</p>
    <p>Role:{{ $user->role }}</p>
@endforeach
<hr/>
<h3>Pluck</h3>
@foreach($roles as $name => $role)
    <h4>Name:{{$name}}</h4>
    <p>Role:{{ $role }}</p>
@endforeach
<hr/>
<h3>Posts of login user</h3>
@foreach($user_posts as $post)
    <h4>Title:{{$post->title}}</h4>
    <p>Content:{{ $post->content }}</p>
@endforeach
<hr/>
<h3>users union</h3>
@foreach($user_unions as $user)
    <p>{{$user->name}}</p>
@endforeach
<hr/>
<h3>users arrwhere</h3>
@foreach($users_arrwhere as $user)
    <p>{{$user->name}}</p>
@endforeach

<hr/>
<h3>users wherein</h3>
@foreach($users_wherein as $user)
    <p>{{$user->name}}</p>
@endforeach
<hr/>
<h3>users wherecolumn</h3>
@foreach($users_wherein as $user)
    <p>{{$user->name}}</p>
@endforeach
<hr/>
<h3>users whereExists</h3>
@foreach($users_whereExists as $user)
    <p>{{$user->name}}</p>
@endforeach

<hr/>
<h3>users when</h3>
@foreach($users_when as $user)
    <p>{{$user->name}}</p>
@endforeach

</div>



@stop