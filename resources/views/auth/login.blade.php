@extends('layout')

@section('title')
Lexpoint login
@stop

@section('headExtra')
{!!Html::style('css/user.css')!!}
@stop

@section('content')


{!! Form::open(array('url'=>'/auth/login', 'class'=>'form-signin')) !!}

        <h2 class="form-signin-heading">{{trans('user.login_title')}}</h2>

        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        {!! Form::text('email',old('email'),array('placeholder'=>'Email', 'class'=>'form-control', 'required'=>'true')) !!}
        {!! Form::input('password','password',null,array('placeholder'=>trans('user.password'),'class'=>'form-control', 'required'=>'true')) !!}

        {!! Form::submit(trans('user.log_in'),array('class'=>'btn btn-lg btn-primary btn-block')) !!}
        <a href="/password/email">{{trans('user.forget_pass')}}</a><br />
        <a href="/auth/register">{{trans('user.register')}}</a>

{!! Form::close() !!}

<p>Login with</p>
<p><a href="{!! route('socialite.auth', 'github') !!}">Github</a></p>
<p><a href="{!! route('socialite.auth', 'google') !!}">Google</a></p>
@stop
