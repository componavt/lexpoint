@extends('layout')

@section('title')
{!!trans('navigation.wiktionary_lab')!!}
@stop

@section('content')
<h1>{!!trans('navigation.wiktionary_lab')!!}</h1>
    <ul>
        <li><a href="/lab/word/">{!!trans('lab.word')!!}</a></li>
        <li><a href="/lab/stats/">{!!trans('lab.stats')!!}</a></li>
    </ul>
@stop

