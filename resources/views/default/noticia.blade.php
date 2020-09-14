@extends(session('projeto').'::template.main')
@section('styles')
    <link rel="stylesheet" href="{{asset('default/css/noticias-galeria.css')}}" />
@endsection

@section('title')
    {{$noticia->titulo}}
@endsection

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li><a href="{{url('noticias')}}">Notícias</a></li>
        <li>{{$noticia->titulo}}</li>
    </ul>
</div>
<h2 class="titulo">{{$noticia->titulo}}</h2>
<div style="position: relative;">
    @if($imagens->count()>0)
    <div class="galeria-container">
        <div class="imagens">
            <a href="" class="bt-imagens bt-anterior bt-iprev">Anterior</a>
            <div class="imagens-container">
                @foreach($imagens as $img)
                <div class="imagem" style="background-color: #ffffff;">
                    @if($img->tipo_arquivo==1)
                    <img src="{{asset($img->path)}}" alt=""/>
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
                        <img src="{{asset($img->getOtherImage(184,120))}}" alt=""/>
                    @else
                        <img src="https://img.youtube.com/vi/{{$img->path}}/2.jpg"/>
                    @endif
                </div>
                @endforeach
            </div>
            <a href="" class="bt-thumbs bt-proxima bt-tnext">Próxima</a>
        </div>
    </div>
    @else
    <img src="{{asset($noticia->imagem)}}" width="100%"/>
    @endif
</div>
<p>{!! str_replace('<p>&nbsp;</p>','',$noticia->conteudo)!!}</p>

@stop

@section('scripts')    
<script src="{{asset('default/js/slick.min.js')}}"></script>
<script>

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