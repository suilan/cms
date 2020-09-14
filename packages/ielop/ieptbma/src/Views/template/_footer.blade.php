<footer class="footer">
    <div class="container">
        <div class="institucional">
            <a href="{{ url('') }}" class="logo" style="background: transparent url({{asset('ieptbma/img/logo-footer.png')}}) no-repeat 0 0;background-size:contain;width: 200px;">Cartórios de Protesto MA</a>
            <a target="_blank" href="https://pt.wikipedia.org/wiki/Cart%C3%B3rios_de_Protesto" class="logo" style="position:relative;">
                <img style="width: 110%; display:block;" src="{{ asset('ieptbma/img/wiki.jpeg') }}" alt="" id="wiki">
            </a>
        </div>
        <div class="menus">
            <div class="coluna">
                <div class="navegacao">
                    <strong class="titulo">NAVEGAÇÃO</strong>
                    <ul class="nav-list">
                        <li class="nav-item"><a href="{{url('')}}" class="nav-link">Página Inicial</a></li>
                        <!-- <li class="nav-item"><a href="{{url('protesto')}}" class="nav-link">Protesto</a>
                            <ul class="subnav-list">
                                <li class="subnav-item"><a href="{{url('protesto')}}" class="subnav-link">O que é</a></li>
                                <li class="subnav-item"><a href="{{url('perguntas')}}" class="subnav-link">Perguntas frequentes</a></li>
                                <li class="subnav-item"><a href="{{url('legislacao')}}" class="subnav-link">Legislação</a></li>
                                <li class="subnav-item"><a href="{{url('galeria')}}" class="subnav-link">Galeria de fotos</a></li>
                            </ul>
                        </li> -->
                        <li class="nav-item"><a href="{{url('noticias')}}" class="nav-link">Notícias</a></li>
                        <!-- <li class="nav-item"><a href="{{url('sobre')}}" class="nav-link">IEPTB-MA</a></li> -->
                        <li class="nav-item"><a href="{{url('eventos')}}" class="nav-link">Eventos</a></li>
                        <li class="nav-item"><a href="{{url('downloads')}}" class="nav-link">Downloads</a></li>
                        <li class="nav-item"><a href="{{url('contato')}}" class="nav-link">Contato</a></li>
                    </ul>
                </div>
            </div>
            <div class="coluna">
                <div class="facilidades">
                    <strong class="titulo">FACILIDADES</strong>
                    <ul class="nav-list">
                        <li class="nav-item"><a target="_blank" href="https://site.cenprotnacional.org.br/" class="nav-link">CENPROT</a></li>
                        <li class="nav-item"><a href="{{url('editais')}}" class="nav-link">EDITAIS DE PROTESTO</a></li>
                        <li class="nav-item"><a href="https://crama.crabr.com.br/crama/site/admin.php" class="nav-link">CRA-MA</a></li>
                    <li class="nav-item"><a href="{{url('protonline')}}" class="nav-link">PROTESTO ONLINE</a></li>
                    </ul>
                </div>
                <div class="visita">
                    <strong class="titulo">FAÇA-NOS <br> UMA VISITA</strong>
                    <address>
                        xxxxx xxxxxxxxxxxx xxxxxxxxxx<br>
                        xxxxxxxxxxxxx xxxxxxxxxxxxxx xxxx <br>
                        CEP: 65074-115, São Luís/MA
                    </address>
                </div>
            </div>
            <div class="coluna">
                <div class="contato">
                    <strong class="titulo">ENTRE EM <br> CONTATO</strong>
                    <span class="telefone">98 xxxx xxxx</span>
                    <br>
                    <span class="telefone">98 xxxx xxxx</span>
                </div>
                <div class="redes">
                    <strong class="titulo">ACOMPANHE-NOS <br> NAS REDES SOCIAIS</strong>
                    <ul class="social-list">
                        <li class="social-item"><a target="_blank" href="https://www.facebook.com/ProtestoMA/" class="social-link facebook"><i class="fa fa-facebook" aria-hidden="true"></i><span class="text">Facebook</span></a></li>
                        <!-- <li class="social-item"><a target="_blank" href="" class="social-link Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i><span class="text">Youtube</span></a></li> -->
                        <li class="social-item"><a target="_blank" href="https://www.instagram.com/ieptbma/" class="social-link instagram"><i class="fa fa-instagram" aria-hidden="true"></i><span class="text">Instagram</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('default.template._copyright', ['company' => 'ielop | Inspiration & Development'])
    
</footer>
