@extends('layout')

@section('title')
Registered users
@stop

@section('content')

<h2 class="form-signin-heading">{{trans('admin.reg_users')}}</h2>
<ul>
@forelse ($users as $user)

<li><a href="/admin/user/{{$user->id}}">{{ $user->name }}</a> ({{ $user->email }}), {{$user->status}}, 
{{trans('user.created_at')}} {{$user->created_at}}</li>

@empty

@endforelse
</ul>

@stop
