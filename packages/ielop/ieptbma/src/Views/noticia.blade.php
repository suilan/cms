@extends('ieptbma::template.main')
@section('content')
<style type="text/css">
	#galeria_button{background:url('{{asset('ieptbma/img/galeria-icon.svg')}}');position: absolute;display: block;width: 100px;height: 100px; top: 10px;right: 10px;border:0;cursor: pointer;}
</style>
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li><a href="{{url('noticias')}}">Notícias</a></li>
        <li>{{$noticia->titulo}}</li>
    </ul>
</div>
<h2 class="titulo">{{$noticia->titulo}}</h2>
<p style="position: relative;">
	<img class="foto" width="100%" src="{{asset($noticia->getOtherImage(1144,600).'?time='.time())}}" >
	@if($imagens->count()>0)
	    <button type="button" id="galeria_button"></button>
	@endif
</p>
<p>{!! str_replace('<p>&nbsp;</p>','',$noticia->conteudo)!!}</p>

<div class="modal">
    <div class="container">
        <a href="" class="bt-fechar">Fechar</a>
        <div class="imagens">
            <a href="" class="bt-imagens bt-anterior bt-iprev">Anterior</a>
            <div class="imagens-container">
            	@foreach($imagens as $img)
                <div class="imagem">
                    @if($img->tipo_arquivo==1)
                        <img src="{{asset($img->getOtherImage(920,518))}}" alt="">
                    @else
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{$img->path}}" frameborder="0" id="display-video" allow="encrypted-media" allowfullscreen></iframe>
                    @endif
                </div>
                @endforeach
            </div>
            <a href="" class="bt-imagens bt-proxima bt-inext">Próxima</a>
        </div>
        <div class="thumbs">
            <a href="" class="bt-thumbs bt-anterior bt-tprev">Anterior</a>
            <div class="thumbs-container">
        		@foreach($imagens as $img)
        	    <div class="thumb">
                    @if($img->tipo_arquivo==1)
                        <img src="{{asset($img->getOtherImage(212,120))}}" alt="">
                    @else
                        <img src="https://img.youtube.com/vi/{{$img->path}}/2.jpg">
                    @endif
                </div>
        	    @endforeach
            </div>
            <a href="" class="bt-thumbs bt-proxima bt-tnext">Próxima</a>
        </div>
    </div>
</div>
@stop

@section('scripts')    
<script src="{{asset('default/js/slick.min.js')}}"></script>
<script>
    $('#galeria_button').click(function(event) {
        event.preventDefault();
        $('.modal').show();
        $('.modal').addClass('show')

        setTimeout(function(){
            // $('.modal').removeClass('show')

            $('.imagens-container').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                asNavFor: '.thumbs-container',
                prevArrow: 'bt-iprev',
                nextArrow: 'bt-inext'
            });
            $('.thumbs-container').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.imagens-container',
                dots: false,
                arrows: true,
                centerMode: true,
                infinite: true,
                focusOnSelect: true,
                prevArrow: 'bt-tprev',
                nextArrow: 'bt-tnext'
            });
        }, 500)
    });

    $('.bt-fechar').click(function(event) {
        event.preventDefault();
        $('.modal').addClass('hide')
        setTimeout(function(){
            $('.modal').hide();
            $('.modal').removeClass('hide')
        }, 500)
    });

    $('.bt-iprev').click(function(event) {
        event.preventDefault();
        $('.imagens-container').slick('slickPrev');
    });

    $('.bt-inext').click(function(event) {
        event.preventDefault();
        $('.imagens-container').slick('slickNext');
    });

    $('.bt-tprev').click(function(event) {
        event.preventDefault();
        $('.thumbs-container').slick('slickPrev');
    });

    $('.bt-tnext').click(function(event) {
        event.preventDefault();
        $('.thumbs-container').slick('slickNext');
    });
</script>
@stop