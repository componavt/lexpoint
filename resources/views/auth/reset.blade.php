@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

<form  class="form-signin" role="form" method="POST" action="/password/reset">

 {!! csrf_field() !!}

        <h2 class="form-signin-heading">{{trans('user.reset_pass')}}</h2>

	<input type="hidden" name="token" value="{{ $token }}">

	@if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
	@endif

	<input type="text" class="form-control" placeholder="Email"  value="{{ old('email') }}" name="email" required/>
        <input type="password" class="form-control" placeholder="{{trans('user.password')}}" name="password" required />
        <input type="password" class="form-control" placeholder="{{trans('user.password_confirmation')}}" name="password_confirmation" required />
	<button class="btn btn-lg btn-primary btn-block" type="submit">{{trans('user.to_reset')}}</button>
</form>

@stop
