@extends('layout')

@section('title')
Lexpoint message
@stop

@section('content')
<h1>{{trans('total.notification_message')}}</h1>
<p>{{trans($message)}}</p>
@stop
