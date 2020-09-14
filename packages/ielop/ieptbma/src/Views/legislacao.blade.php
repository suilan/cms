@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>Legislação</li>
    </ul>
</div>
<h2 class="titulo">Legislação</h2>
<p>O Serviço de notas e registros, ai incluído os serviços de protesto, é norteado pela Constituição Federal de 1988, e regulada tanto por normas federais, como estaduais, conforme os limites de competência. São as seguintes leis orientadoras da atividade:</p>
<strong class="subtitulo">Gerais - Federais</strong>
<ul class="links">
    @foreach ($legislacao as $k=>$r)
        @if($r->tipo_legislacao_id === 1)
            <li class="link">
                @if( $r->arquivo != "" )
                    <a href="{{ url('').$r->arquivo}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @else
                    <a href="{{$r->arquivo_url}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @endif
            </li>
        @endif
    @endforeach
</ul>
<strong class="subtitulo">Especiais - Federais</strong>
<ul class="links">
    @foreach ($legislacao as $k=>$r)
        @if($r->tipo_legislacao_id === 2)
            <li class="link">
                @if( $r->arquivo != "" )
                    <a href="{{ url('').$r->arquivo}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @else
                    <a href="{{$r->arquivo_url}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @endif
            </li>
        @endif
    @endforeach
</ul>
<strong class="subtitulo">Gerais - Estaduais</strong>
<ul class="links">
    @foreach ($legislacao as $k=>$r)
        @if($r->tipo_legislacao_id === 3)
            <li class="link">
                @if( $r->arquivo != "" )
                    <a href="{{ url('').$r->arquivo}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @else
                    <a href="{{$r->arquivo_url}}" class="bt-download" target="_blank">{{$r->descricao}}</a>
                @endif
            </li>
        @endif
    @endforeach
</ul>

@stop