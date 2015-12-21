@extends('layout')

@section('title')
Lexpoint
@stop

@section('content')

{!! Form::open(array('url'=>'/admin/user/'.$user->id, 'class'=>'form-signin', 'method'=>'put')) !!}

        <h2 class="form-signin-heading">{{trans('admin.edit_user')}}</h2>

        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

	<b>{{trans('user.name')}}</b> {!! Form::text('name',$user->name,array('class'=>'form-control', 
'required'=>'true')) !!} 
	<b>Email</b>{!! Form::email('email',$user->email,array('class'=>'form-control', 'required'=>'true')) !!} 

	<b>{{trans('user.status')}}</b> {!! Form::select('status',$user_status_list,$user->status) !!}
	<b>{{trans('user.is_activated')}}</b> {!! Form::select('isActive',array(1=>trans('total.1'),0=>trans('total.0')),$user->isActive) !!}<br/>
	<b>{{trans('user.password')}}</b> {!! Form::input('password','password',null,array('class'=>'form-control')) !!} 
	<b>{{trans('user.password_confirmation')}}</b> {!! Form::input('password','password_confirmation',null,array('class'=>'form-control')) !!} 
	{!! Form::submit(trans('total.save'),array('class'=>'btn btn-lg btn-primary btn-block')) !!}

{!! Form::close() !!}

@stop
