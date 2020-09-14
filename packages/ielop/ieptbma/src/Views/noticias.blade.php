@extends('ieptbma::template.main')

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Notícias</li>
    </ul>
</div>
<h2 class="titulo">Notícias</h2>
<div class="filtro">
    <form action="{{url('noticias')}}" name="formBuscaNoticia">
        <input type="text" name="busca" id="busca" placeholder="Busca por palavra-chave" />
        <i class="fa fa-search" aria-hidden="true"></i>
    </form>
</div>
<div class="noticias-list">
    @foreach( $noticias as $k=>$r )
        <div class="noticia">
            <a class="noticia-link" href="{{url('noticias/'.$r->slug)}}">
                <div class="thumb">
                    @if( $r->imagem != "" )
                        <img class="foto" src="{{asset($r->getOtherImage(310,200).'?time='.time())}}" >
                    @elseif ( $r->imagem_url != "" )
                        <img class="foto" src="{{$r->imagem_url}}" >
                    @else
                        <img class="foto" src="http://placehold.it/310x200" >
                    @endif
                </div>
                <div class="data">
                    <span class="dia">{{$r->dia}}</span>
                    <span class="mes">{{$mes[$r->mes]}}</span>
                </div>
                <div class="texto">
                    <h3 class="chamada" title="{{$r->titulo}}">{{str_limit($r->titulo, 75)}}</h3>
                    <p>{{$r->descricao}}</p>
                    <i class="fa fa-arrow-right " aria-hidden="true"></i>
                </div>
            </a>
        </div>
    @endforeach
</div>
<div class = "pagination_list">
    @if( Input::get('busca') )
        {!! $noticias->appends(['busca' => Input::get('busca')])->render() !!}
    @else
        {!! $noticias->render() !!}
    @endif
</div>
<!-- <a href="" class="bt-carregarmais">Carregar mais</a> -->
@stop
            