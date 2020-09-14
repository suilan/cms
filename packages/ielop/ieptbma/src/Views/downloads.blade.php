@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Downloads</li>
    </ul>
</div>
<h2 class="titulo">Downloads</h2>
<p>Arquivos disponibilizado pelo IEPTB-MA para Download </p>

<strong class="subtitulo">Informativo</strong>
<ul class="links">
    @foreach( $downloads as $k=>$b )
        <li class="link">
        	@if( $b->arquivo != "" )
                <a href="{{ url('').$b->arquivo}}" class="bt-download" target="_blank">{{$b->titulo}}</a>
            @else
                <a href="{{$b->arquivo_url}}" class="bt-download" target="_blank">{{$b->titulo}}</a>
            @endif
        </li>
    @endforeach
</ul>
@stop
