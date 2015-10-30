@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

<form  class="form-signin" role="form" method="POST" action="/password/email">

 {!! csrf_field() !!}

        <h2 class="form-signin-heading">{{trans('user.pass_recovery')}}</h2>

	@if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    	@endif

	<input type="text" class="form-control" placeholder="Email"  value="{{ old('email') }}" name="email" required/>
	<button class="btn btn-lg btn-primary btn-block" type="submit">{{trans('user.to_recover')}}</button>
</form>

@stop
