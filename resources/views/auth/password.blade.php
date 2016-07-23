@extends('layout')

@section('title')
Lexpoint
@stop

@section('headExtra')
{!!Html::style('css/user.css')!!}
@stop

@section('content')

{!! Form::open(array('url'=>'/password/email', 'class'=>'form-signin')) !!}

        <h2 class="form-signin-heading">{{trans('user.pass_recovery')}}</h2>

        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        {!! Form::email('email',old('email'),array('placeholder'=>'Email', 'class'=>'form-control', 'required'=>'true')) !!}

        {!! Form::submit(trans('user.to_recover'),array('class'=>'btn btn-lg btn-primary btn-block')) !!}

{!! Form::close() !!}

@stop
