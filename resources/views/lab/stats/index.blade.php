@extends('layout')

@section('title')
{!!trans('lab.stats')!!}
@stop


@section('content')
        <h1>{!!trans('lab.stats')!!}</h1>
    <ul>
        <li><a href="/lab/stats/languages/">{!!trans('lab.languages')!!}</a></li>
    </ul>
@stop

