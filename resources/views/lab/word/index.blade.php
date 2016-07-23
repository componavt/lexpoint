@extends('layout')

@section('headExtra')
{!!Html::style('css/word.css')!!}
{!!Html::script('js/toggleText.js')!!}
@stop

@section('title')
{!!trans('lab.word')!!}
@stop


@section('content')

        <h1>{!!trans('lab.word')!!}</h1>
        {!! Form::open(array('url' => '/lab/word', 
                       'method' => 'get', 
                       'class' => 'form-inline')) 
            !!}
        <!--{!! Form::text('search_word', old('search_word'), array('placeholder'=>trans('lab.word'), 'class'=>'form-control', 'required'=>'true')) !!} -->
        {!! Form::text('search_word', 
                       $search_word, 
                       array('placeholder'=>trans('lab.word'), 
                             'class'=>'form-control', 
                             'required'=>'true')) 
            !!} 
        {!! Form::select('type_search', [
                            'exact' => trans('lab.exact_search'),
                            'sub' => trans('lab.sub_search')],
                         $type_search,
                         ['class'=>'form-control'])
            !!} 
        {!! Form::label('output_first', 
                        trans('lab.output_first')) 
            !!}
        {!! Form::text('output_first', 
                       $output_first, 
                       array('class'=>'form-control',
                              'size'=>5)) 
            !!} 
        <b>{!! trans('total.records') !!}</b>
        {!! Form::submit(trans('total.search'),
                         array('class'=>'btn btn-default btn-primary')) 
            !!}
        {!! Form::close() !!}

        @if ($search_word)
        <p class="found">{{ $total_message }}
            @if ($restriction_message)
            <br>{{ $restriction_message }}
            @endif
        </p>
        @endif

        @foreach($words as $count => $word)
        <div class="word-block">    
            <h2 class="word-title">{{ $count }}. {{ $word['title']}}</h2>
            @if ($word['link'])
            <p>{!!trans('lab.source_page_at')!!} {!! $word['link'] !!}</p>
            @endif

            @foreach($word['lang_pos'] as $lang_pos)
            <div class="lang-pos-block">    
                <h3 class="lang-pos-lang">{{ $lang_pos['lang'] }}</h3>
                <p>{!! trans('lab.pos') !!}: <b>{{ $lang_pos['pos'] }}</b></p>

                @foreach($lang_pos['meaning'] as $meaning_count => $meaning_info)
                <p>{{ $meaning_count }}. {!! $meaning_info['text'] !!}</p> 
                <div class="relation-block">
                    @foreach($meaning_info['relation'] as $rel_type => $relations)
                    <p><b>{{ $rel_type }}</b>: {{ $relations }}</p>
                    @endforeach 

                    @if ($meaning_info['translation']['lang_count']>0)
                    <p><b>{!! trans('lang.translation') !!}</b>
                        @if ($meaning_info['translation']['summary'])
                            ({!! $meaning_info['translation']['summary'] !!})@endif:
                        {!! trans('lang.languages') !!}: {{ $meaning_info['translation']['lang_count'] }},
                        {!! trans('lang.translations') !!}: {{ $meaning_info['translation']['trans_count'] }},
                        <a id="displayText{{ $meaning_count }}" href="javascript:toggleText('displayText{{ $meaning_count }}', 
                                                                                            'toggleText{{ $meaning_count }}', 
                                                                                            '{!! trans('total.show') !!}',
                                                                                            '{!! trans('total.hide') !!}');">{!! trans('total.show') !!}</a></p>
                    </p>
                    <div id="toggleText{{ $meaning_count }}" class="all-translations">
                        @foreach ($lang_pos['meaning'][$meaning_count]['translation']['trans'] as $lang => $trans)
                            <i>{{ $lang }}</i>: {{ $trans }}<br />
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        @endforeach

@stop

