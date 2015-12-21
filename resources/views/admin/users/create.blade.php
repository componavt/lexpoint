@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

{!! Form::open(array('url'=>'/admin/user', 'class'=>'form-signin')) !!}

        <h2 class="form-signin-heading">{{trans('user.register')}}</h2>

        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

	{!! Form::text('name',old('name'),array('placeholder'=>trans('user.name'), 'class'=>'form-control', 'required'=>'true')) !!} 
	{!! Form::email('email',old('email'),array('placeholder'=>'Email', 'class'=>'form-control', 'required'=>'true')) !!} 

	<b>{{ trans('user.status') }}</b> {!! Form::select('status',$user_status_list) !!}
	{!! Form::input('password','password',null,array('placeholder'=>trans('user.password'), 
'class'=>'form-control', 'required'=>'true')) !!} 
	{!! Form::input('password','password_confirmation',null,array('placeholder'=>trans('user.password_confirmation'), 
'class'=>'form-control', 'required'=>'true')) !!} 
	{!! Form::submit(trans('user.register'),array('class'=>'btn btn-lg btn-primary btn-block')) !!}

{!! Form::close() !!}

@stop
