@extends('layout')

@section('title')
{!!trans('lab.word')!!}
@stop


@section('content')

        <h1>{!!trans('lab.word')!!}</h1>
        {!! Form::open(array('url' => '/lab/word', 'method' => 'get', 'class' => 'form-inline')) !!}
        <!--{!! Form::text('search_word', old('search_word'), array('placeholder'=>trans('lab.word'), 'class'=>'form-control', 'required'=>'true')) !!} -->
        {!! Form::text('search_word', $search_word, array('placeholder'=>trans('lab.word'), 'class'=>'form-control', 'required'=>'true')) !!} 
        {!! Form::submit(trans('total.search'),array('class'=>'btn btn-default btn-primary')) !!}
        {!! Form::close() !!}

        <p>{{ $found_message }}</p>
        @foreach($words as $word)
            <h2>{{ $word['title']}}</h2>

        @endforeach

@stop

