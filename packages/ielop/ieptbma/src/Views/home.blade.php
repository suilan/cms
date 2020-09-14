@include('ieptbma::template._head')
<body>

    <script type="text/javascript">
        function fixCarousel(event) {
            var windowWidth = window.innerWidth?window.innerWidth:document.clientWidth,
            windowHeight = window.innerHeight?window.innerHeight:document.clientHeight,
            imgWidth = 3430;

            // console.log(event.target.height)
            if( windowWidth>imgWidth )
            {
                event.target.style.height = 'auto';
                event.target.style.width=windowWidth+"px";
            }
            else{
                event.target.style.width = 'auto';
                event.target.style.height=600 + "px";
            }

            document.getElementsByClassName('banners-wrap')[0].style.height=event.target.style.height;
        }
    </script>

    @include('ieptbma::template._header')
    <div class="banners-wrap">
        <div class="banner-list">
            @foreach($banner as $k=>$b)
                <div class="banner" style="background-image: url({{ URL::asset($b->getOtherImage(3430,1135)) }}); width: 1905px; background-size:{{$k!=0?'auto 85%':'cover'}};background-color: #0099ba; background-repeat: no-repeat;" >
                    @if($k == 0)
                        <div class="container">
                            <div class="text">
                                <h2 class="titulo">ielop <br> </h2> <span class="semnegrito" style="">Inspiration & Development</span>
                                <span class="descricao" style="text-align: right;">CMS Project</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            @foreach($carousel as $k=>$b)
                <a target="_blank" href="{{$b->link}}">
                    <div class="banner" style="background-image: url({{ URL::asset($b->getOtherImage(3430,1135)) }}); 
                                            background-size:cover;
                                            background-color: #0099ba;
                                            background-repeat: no-repeat;">
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="content">
        <section class="facilidades" style="margin-bottom:2px">
            <div class="container">
                <a href="https://site.cenprotnacional.org.br/" class="facilidade cnp" target="_blank">
                    <h3 class="titulo">CENTRAL NACIONAL DE PROTESTO</h3>
                    <p>
                        <ul style="width: 117%;">
                            <li>Consulta Gratuita de Protesto</li>
                            <li>Solicitação de Certidão</li>
                            <li>Carta de Anuência</li>
                            <li>Cancelamento de Protesto</li>
                            <li>Envio de Títulos a Protesto</li>
                        </ul>
                    </p>
                </a>
                <a href="https://www.jornaldoprotestoma.com.br/" class="facilidade editais" target="_blank">
                    <h3 class="titulo">JORNAL DO PROTESTO DO MARANHÃO</h3>
                    <p style="width: 117%;">Diário Eletrônico com notícias sobre os Cartórios do Estado do Maranhão e publicação de Editais de Protesto do dia.</p>
                </a>
                <a href="https://crama.crabr.com.br/crama/site/admin.php" class="facilidade cra" target="_blank">
                    <h3 class="titulo">CRA-MA</h3>
                    <p>Acesso ao sistema Web da Central de Remessas de Arquivos do Maranhão (CRA-MA)</p>
                </a>
                <a href="{{ url('protonline') }}" class="facilidade protesto" target="_blank">
                    <h3 class="titulo">Seja Conveniado</h3>
                    <p style="width: 212px">Pensado para empresas de todos os portes, proporciona o envio 100% eletrônico de títulos a protesto para qualquer Cartório do Maranhão através da CRA-MA.</p>
                </a>
            </div>
        </section>
        {{-- <section class="noticias" style="background-color: #e9e9e9">
            <div class="container">
                <div class="aside">
                    <h2 class="titulo">Emissão de segunda via <strong>de Boletos</strong></h2>
                    <p class="descricao">Sessão para emissão de segunda via de boletos de títulos a protesto.</p>
                </div>
                <div class="noticias-list">
                    @if(Session::has('message1'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!!Session::get('message1')!!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="noticia" style="width: 100%">
                        <div class="thumb">
                             <form method="GET" action="{{ url('impressaosegundavia') }}">
                                <input type="hidden" id="cainput_token" name="_token" value="">
                                <label for="protocolo" class="protocolo" style="display: block; margin: 0 0 20px; overflow: hidden;">
                                    <span class="text" style="display: block; margin: 0 0 0 1px; font-size: 16px; font-family: Gotham-Book;">Protocolo:</span>
                                    <input type="text" name="protocolo" id="protocolo" required="true" style="display: block;
                                    width: 100%;
                                    height: 52px;
                                    -moz-box-sizing: border-box;
                                    -webkit-box-sizing: border-box;
                                    -webkit-box-sizing: border-box;
                                    -moz-box-sizing: border-box;
                                    -o-box-sizing: border-box;
                                    box-sizing: border-box;
                                    padding: 0 20px;
                                    border: 2px solid #d2d2d2;
                                    -webkit-border-radius: 6px;
                                    -moz-border-radius: 6px;
                                    -o-border-radius: 6px;
                                    border-radius: 6px;
                                    font-size: 16px;
                                    font-family: Gotham-Book;">
                                </label>
                                <button style="display: inline-block;
                                height: 35px;
                                padding: 0 40px;
                                line-height: 35px;
                                -webkit-border-radius: 30px;
                                -moz-border-radius: 30px;
                                -o-border-radius: 30px;
                                border-radius: 30px;
                                text-transform: uppercase;
                                font-family: Gotham-Bold;
                                color: #fff;
                                font-size: 12px;
                                text-decoration: none;
                                background: #00b4db;" id="emite" class="bt-vertodas">Buscar</a>
                            </form> --}}
                            {{-- <iframe width="812" height="457" src="https://www.youtube.com/embed/OdMNW09--rI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div> --}}
                            {{-- <div class="data">
                                <span class="dia">{{$r->dia}}</span>
                                <span class="mes">{{$mes[$r->mes]}}</span>
                            </div>
                            <div class="texto">
                                <h3 class="chamada">{{$r->titulo}}</h3>
                                <p>{{$r->descricao}}</p>
                                <i class="fa fa-arrow-right " aria-hidden="true"></i>
                            </div> --}}
                    {{-- </div>
                </div>
            </div>
        </section> --}}
        <section class="noticias">
            <div class="container">
                <div class="aside">
                    <h2 class="titulo">Últimas <strong>Notícias</strong></h2>
                    <p class="descricao">Corregedoria implanta melhorias para os serviços cartorários do Estado</p>
                    <a href="{{url('noticias')}}" class="bt-vertodas">Ver todas</a>
                </div>
                <div class="noticias-list">
                @foreach( $noticias as $k=>$r )
                    <div class="noticia">
                        <a class="noticia-link" href="{{url('noticias/'.$r->slug)}}">
                            <div class="thumb">
                                @if( $r->imagem != "" )
                                    <img class="foto" src="{{asset($r->getOtherImage(410,220).'?time='.time())}}" >
                                @elseif ( $r->imagem_url != "" )
                                    <img class="foto" src="{{$r->imagem_url}}" >
                                @else
                                    <img class="foto" src="http://placehold.it/410x220" >
                                @endif
                            </div>
                            <div class="data">
                                <span class="dia">{{$r->dia}}</span>
                                <span class="mes">{{$mes[$r->mes]}}</span>
                            </div>
                            <div class="texto">
                                <h3 class="chamada">{{$r->titulo}}</h3>
                                <p>{{$r->descricao}}</p>
                                <i class="fa fa-arrow-right " aria-hidden="true"></i>
                            </div>
                        </a>
                    </div>
                @endforeach
                </div>
            </div>
        </section>
        <section class="parceiros">
            <div class="container">
                <div class="aside">
                    <h2 class="titulo">Nossos <strong>Parceiros</strong></h2>
                    <div class="navegacao">
                        <a href="" class="bt-setas bt-anterior"><span>Anterior</span></a>
                        <a href="" class="bt-setas bt-proxima"><span>Próxima</span></a>
                    </div>
                </div>
                <script>
                    function hideGray(event) {
                        event.target.style.display='none';
                        event.target.parentNode.children[1].style.display='block';
                    }
                    function showGray(event) {
                        event.target.style.display='none';
                        event.target.parentNode.children[0].style.display='block';
                    }
                </script>
                <ul class="pareiros-list">
                    <li class="parceiro-item">
                        <a href="http://protestodetitulos.org.br/" target="_blank" class="parceiro-link">
                            <img src="{{ URL::asset('/') }}ieptbma/img/ieptbgray.png" class="logo-gray" alt="Cartório de Protestos IEPTB-BR" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('/') }}ieptbma/img/ieptb.png" class="logo-colored" style="display:none;  height: 120px" alt="Cartório de Protestos IEPTB-BR" onmouseleave="showGray(event);">
                        </a>
                    </li>
                    <li class="parceiro-item">
                        <a href="http://www.tjma.jus.br/" class="parceiro-link" target="_blank">
                            <img src="{{ URL::asset('/') }}ieptbma/img/logo-tribunal.png" class="logo-gray" alt="Tribunal de Justiças do Estado do Maranhão" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('/') }}ieptbma/img/logo-tribunal-color.png" class="logo-colored" style="display:none;  height: 120px" alt="Tribunal de Justiças do Estado do Maranhão" onmouseleave="showGray(event);">
                        </a>
                    </li>
                    <li class="parceiro-item">
                        <a href="http://www.anoregpr.org.br/" class="parceiro-link" target="_blank">
                            <img src="{{ URL::asset('/') }}ieptbma/img/anoreg_br_gray.png" class="logo-gray" alt="ANOREG BR" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('/') }}ieptbma/img/anoreg_br_colored.png" class="logo-colored" style="display:none;  height: 120px" alt="ANOREG BR" onmouseleave="showGray(event);">
                        </a>
                    </li>
                    <li class="parceiro-item">
                        <a href="https://www.cartoriosmaranhao.com.br/" class="parceiro-link" target="_blank">
                            <img src="{{ URL::asset('/') }}ieptbma/img/cartorios.png" class="logo-gray" alt="Cartórios MA" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('/') }}ieptbma/img/cartorios-color.png" class="logo-colored" style="display:none;  height: 120px" alt="Cartórios MA" onmouseleave="showGray(event);">
                        </a>
                    </li>
                    <li class="parceiro-item">
                        <a href="http://www.cnj.jus.br/" class="parceiro-link" target="_blank">
                            <img src="{{ URL::asset('/') }}ieptbma/img/cnj_grey_new.jpeg" class="logo-gray" alt="CNJ" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('/') }}ieptbma/img/cnj_new_grey.jpeg" class="logo-colored" style="display: none; height: 120px" alt="CNJ" onmouseleave="showGray(event);">
                        </a>
                    </li>
                    <li class="parceiro-item">
                        <a href="http://www.tjma.jus.br/cgj/index" class="parceiro-link" target="_blank">
                            <img src="{{ URL::asset('ieptbma/img/corregedoria.jpg') }}" class="logo-gray" alt="CNJ" onmouseover="hideGray(event);" style=" height: 120px">
                            <img src="{{ URL::asset('ieptbma/img/corregedoria-color.jpg') }}" class="logo-colored" style="display:none;  height: 120px" alt="CNJ" onmouseleave="showGray(event);">
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
    
    <div class="remodal" data-remodal-id="modal" style="max-width: 1370px; background:none; padding:0">
        <button data-remodal-action="close" class="remodal-close"></button>
        {{--  <h1 class="logo"></h1>  --}}
        <p class="titulo">
            {{--  Está disponível a nova versão da Cartilha contendo orientações para o repasse de valores aos apresentantes.  --}}
             <a href="https://ieptbma.com.br/eventos/provimento-88-cnj-atuacao-dos-tabeliaes-de-notas-e-protesto-na-prevencao-a-lavagem-de-dinheiro">
                <img src="https://ieptbma.com.br/images/poupup_site.jpg" style="height: 600px;" alt="PROVIMENTO 88 CNJ: ATUAÇÃO DOS TABELIÃES DE NOTAS E PROTESTO NA PREVENÇÃO À LAVAGEM DE DINHEIRO" />
            </a> 
            {{-- <img src="{{ URL::asset('ieptbma/img/newmodal.jpeg')}}" alt="Novo modal - Contra golpes" /> --}}
        </p>

        {{--  <a href="{{URL::asset($ultimaCartilha->arquivo)}}" data-remodal-action="cancel" class="remodal-confirm" target="_blank">Visualizar</a>  --}}
    </div>

    {{--  
        
        Versão retirada por conta do modal do não cia contra golpes

        <div class="remodal" data-remodal-id="modal">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h1 class="logo"></h1>
        <p class="titulo">
            Está disponível a nova versão da Cartilha contendo orientações para o repasse de valores aos apresentantes.
        </p>

        <a href="{{URL::asset($ultimaCartilha->arquivo)}}" data-remodal-action="cancel" class="remodal-confirm" target="_blank">Visualizar</a>
    </div>  --}}

   <!--  <div class="remodal" data-remodal-id="modal" style=" background-size: 100%; background-repeat: no-repeat; background-image: url({{ URL::asset('images/inscricos_encerradas.jpeg') }})">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h1 class="logo"></h1>
        <p class="titulo">
            Está disponível a nova versão da Cartilha contendo orientações para o repasse de valores aos apresentantes.
        </p>

        <a href="{{url('images/downloads-id_1.pdf')}}" style="margin-top: 270px" data-remodal-action="cancel" class="remodal-confirm" target="_blank">Download da Cartilha</a>
    </div> -->

    @include('ieptbma::template._footer')
    @include('ieptbma::template._scripts')
    <script src="{{asset('default/js/slick.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.banner-list').slick({
                arrows: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000
            });

            $('.pareiros-list').slick({
                prevArrow: '.bt-anterior',
                nextArrow: '.bt-proxima',
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                variableWidth: true,
                autoplay: true,
                centerMode: false,
                autoplaySpeed: 3000
            });

            $('.banner').css({
                width: $(window).width() + 'px'
            });
        });
    </script>
    {{-- <script type="text/javascript">
        $(function() {
            var inst = $('[data-remodal-id=modal]').remodal();
            inst.open();
        });
    </script> --}}
    <script type="text/javascript">
        $(document).on('cancellation', '.remodal', function (e) {
            // Reason: 'confirmation', 'cancellation'
            window.open("{{URL::asset($ultimaCartilha->arquivo)}}", "_blank");
        });
    </script> 
</body>
</html>
