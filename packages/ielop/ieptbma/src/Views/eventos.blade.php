@extends('ieptbma::template.main')
@section('content')

<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Eventos</li>
    </ul>
</div>
<div id="g-about" class="row">
    <div class="col-md-6">
        <h2 class="titulo">Próximos Eventos</h2>
        @if(sizeof($eventosProximos) > 0)
            <div class="noticias-list">
                @foreach( $eventosProximos as $k=>$r )
                    <div class="noticia eventos">
                        <a class="noticia-link" href="{{url('eventos/'.$r->slug)}}">
                            <div class="thumb">
                                @if( $r->imagem_arquivo != "" )
                                    <img class="foto" src="{{asset($r->getOtherImage(310,200))}}" >
                                @elseif ( $r->imagem_url != "" )
                                    <img class="foto" src="{{asset($r->imagem_url)}}" >
                                @else
                                    <img class="foto" src="http://placehold.it/310x200" >
                                @endif
                            </div>
                            <div class="data">
                                <span class="dia">{{$r->dia}}</span>
                                <span class="mes">{{$mes[$r->mes]}}</span>
                            </div>
                            <div class="texto">
                                <h3 class="chamada">{{$r->titulo}}</h3>
                                
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p>Não há eventos a serem realizados.</p>
        @endif
    </div>
    @if(sizeof($eventosPassados) > 0)
        <div class="col-md-6">
            <h2 class="titulo" style="margin-top: 450px">Eventos Anteriores</h2>
            <div class="noticias-list" style="float: left">
                @foreach( $eventosPassados as $k=>$r )
                    <div class="noticia eventos">
                        <a class="noticia-link" href="{{url('eventos/'.$r->slug)}}">
                            <div class="thumb" style="height: 135px; margin-bottom: 11px;">
                                @if( $r->imagem_arquivo != "" )
                                    <img style="width: 210px" class="foto" src="{{ url(''.$r->getOtherImage(210,100))}}" >
                                @elseif ( $r->imagem_url != "" )
                                    <img style="width: 210px" class="foto" src="{{url(''.$r->imagem_url)}}" >
                                @else
                                    <img style="width: 210px" class="foto" src="http://placehold.it/210x100" >
                                @endif
                            </div>
                            <div class="data" style="height: 50px; width: 12%; padding-top: 5px">
                                <span class="dia" style="font-size: 15px">{{$r->dia}}</span>
                                <span class="mes" style="font-size: 15px">{{ $mes[$r->mes]}}</span>
                            </div>
                            <div class="texto" style="width: 57%; padding-left: 4%">
                                <h3 class="chamada" style="font-size: 12px">{{$r->titulo}}</h3>
                                <p>{{$r->descricao}}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@stop
            