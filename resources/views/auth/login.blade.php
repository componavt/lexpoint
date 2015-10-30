@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

<form  class="form-signin" role="form" method="POST" action="/auth/login">

 {!! csrf_field() !!}

        <h2 class="form-signin-heading">{{trans('user.login_title')}}</h2>
        <input type="text" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" required autofocus />
        <input type="password" class="form-control" placeholder="Password" name="password" required />
        <label class="checkbox">
            <input type="checkbox" name="remember" value="remember-me"> {{trans('user.remember_me')}}
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">{{trans('user.log_in')}}</button>

        <a href="/password/email">{{trans('user.forget_pass')}}</a><br />
        <a href="/auth/register">{{trans('user.register')}}</a>
    </form>

@stop
