@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

<form  class="form-signin" role="form" method="POST" action="/auth/register">

 {!! csrf_field() !!}

        <h2 class="form-signin-heading">{{trans('user.register')}}</h2>


	<input type="text" class="form-control" placeholder="{{trans('user.name')}}"  value="{{ old('name') }}" name="name" required/>
	<input type="text" class="form-control" placeholder="Email"  value="{{ old('email') }}" name="email" required/>
        <input type="password" class="form-control" placeholder="{{trans('user.password')}}" name="password" required />
        <input type="password" class="form-control" placeholder="{{trans('user.password_confirmation')}}" name="password_confirmation" required />
	<button class="btn btn-lg btn-primary btn-block" type="submit">{{trans('user.register')}}</button>
</form>

@stop
