@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Galeria de Fotos</li>
    </ul>
</div>
<h2 class="titulo">Galeria de Fotos</h2>
<p></p>
<div class="albuns">
    <div class="album">
        <div class="foto">
            <img src="{{asset('ieptbma/img/temp-foto1.jpg')}}" alt="" />
        </div>
        <span class="nome">Evento de inauguração do 2 tabelionato</span>
    </div>
    <div class="album">
        <div class="foto">
            <img src="{{asset('ieptbma/img/temp-foto2.jpg')}}" alt="" />
        </div>
        <span class="nome">Evento de inauguração do 2 tabelionato</span>
    </div>
    <div class="album">
        <div class="foto">
            <img src="{{asset('ieptbma/img/temp-foto3.jpg')}}" alt="" />
        </div>
        <span class="nome">Evento de inauguração do 2 tabelionato</span>
    </div>
    <div class="album">
        <div class="foto">
            <img src="{{asset('ieptbma/img/temp-foto4.jpg')}}" alt="" />
        </div>
        <span class="nome">Evento de inauguração do 2 tabelionato</span>
    </div>
</div>
<div class="modal">
    <div class="container">
        <a href="" class="bt-fechar">Fechar</a>
        <div class="imagens">
            <a href="" class="bt-imagens bt-anterior bt-iprev">Anterior</a>
            <div class="imagens-container">
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto1.jpg')}}" alt=""></div>
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto2.jpg')}}" alt=""></div>
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto3.jpg')}}" alt=""></div>
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto4.jpg')}}" alt=""></div>
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto5.jpg')}}" alt=""></div>
                <div class="imagem"><img src="{{asset('ieptbma/img/temp-foto6.jpg')}}" alt=""></div>
            </div>
            <a href="" class="bt-imagens bt-proxima bt-inext">Próxima</a>
        </div>
        <div class="thumbs">
            <a href="" class="bt-thumbs bt-anterior bt-tprev">Anterior</a>
            <div class="thumbs-container">
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto1-thumb.jpg')}}" alt=""></div>
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto2-thumb.jpg')}}" alt=""></div>
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto3-thumb.jpg')}}" alt=""></div>
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto4-thumb.jpg')}}" alt=""></div>
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto5-thumb.jpg')}}" alt=""></div>
                <div class="thumb"><img src="{{asset('ieptbma/img/temp-foto6-thumb.jpg')}}" alt=""></div>
            </div>
            <a href="" class="bt-thumbs bt-proxima bt-tnext">Próxima</a>
        </div>
    </div>
</div>
@stop

@section('scripts')    
<script src="{{asset('default/js/slick.min.js')}}"></script>
<script>
    $('.album').click(function(event) {
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

