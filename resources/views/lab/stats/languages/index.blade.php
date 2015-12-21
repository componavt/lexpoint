@extends('layout')

@section('title')
Languages
@stop

@section('headExtra')
<script type="text/javascript" src="/js/tablesorter/jquery-latest.js"></script> 
<script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="/js/tablesorter/themes/blue/style.min.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#languages").tablesorter(); 
    } 
); 
</script>
@stop

@section('content')

        <h2>Languages</h2>
        <p>{{ Lang::get('total.total_count',array('count'=>$total_count)) }}</p>
    <table id="languages" class="table tablesorter">
	<thead>
        <tr>
            <th>Language name</th>
            <th>Language code</th>
            <th>Number of foreign parts of speech (POS) in the table index_XX</th>
            <th>Number of translation pairs in the table index_XX:</th>
        </tr>
	</thead>
	<tbody>
        @foreach($languages as $language)
        <tr>
            <td>{{$language->name}}</td>
            <td>{{$language->code}}</td>
            <td>{{$language->n_foreign_POS}}</td>
            <td>{{$language->n_translations}}</td>
        </tr>
        @endforeach
	</tbody>
    </table>
@stop

