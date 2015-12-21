@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')


{!! Form::open(array('url'=>'/password/reset', 'class'=>'form-signin')) !!}

        <h2 class="form-signin-heading">{{trans('user.reset_pass')}}</h2>

	@if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
	@endif

	{!! Form::hidden('token',$token) !!}

        {!! Form::email('email',old('email'),array('placeholder'=>'Email', 'class'=>'form-control', 'required'=>'true')) !!}
        {!! Form::input('password','password',null,array('placeholder'=>trans('user.password'),'class'=>'form-control', 'required'=>'true')) !!}
        {!! Form::input('password','password_confirmation',null,array('placeholder'=>trans('user.password_confirmation'),'class'=>'form-control', 'required'=>'true')) !!}

        {!! Form::submit(trans('user.to_reset'),array('class'=>'btn btn-lg btn-primary btn-block')) !!}

{!! Form::close() !!}

@stop
