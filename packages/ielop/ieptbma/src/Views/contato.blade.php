@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>Contato</li>
    </ul>
</div>
<h2 class="titulo">Contato</h2>
@if( !Session::get('success') )
    @if(isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p>Para nos enviar uma mensagem, solicitar informações ou mandar sugestões, por favor, preencha corretamente os campos abaixo.</p>
    <form method="post" action="{{url('contato')}}">
        <input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
        <label for="nome" class="nome">
            <span class="text">Nome:</span>
            <input type="text" name="nome" required="true" />
        </label>
        <label for="email" class="email">
            <span class="text">Email:</span>
            <input type="email" name="email" required="true" />
        </label>
        <label for="assunto" class="assunto">
            <span class="text">Assunto:</span>
            <input type="text" name="assunto" required="true" />
        </label>
        <label for="mensagem" class="mensagem">
            <span class="text">Mensagem:</span>
            <textarea name="mensagem" cols="30" rows="10" required="true" ></textarea>
        </label>
        <button class="bt-enviar">Enviar</button>
        <em class="obs">*Todos os campos são obrigatórios</em>
    </form>
@else
    <p>Sua mensagem foi enviada com sucesso!</p>
    <a href="{{url('contato')}}">Voltar</a>
@endif
<div class="aside">
    <div class="telefone">
        <h2 class="subtitulo">Ligue para nós</h2>
        <span class="numero"><i class="fa fa-phone" aria-hidden="true"></i> 98 3304 8117</span>
        <br>
        <span class="numero"><i class="fa fa-phone" aria-hidden="true"></i> 98 3304 8119</span>
    </div>
    <div class="telefone">
        <h2 class="subtitulo">E-mail</h2>
        <span class="numero" style="font-size: 22px;"><i class="fa fa-envelope" aria-hidden="true" style="margin-right: 5px"></i>contato@ieptbma.com.br</span>
    </div>
    <div class="sociais">
        <h2 class="subtitulo">Acompanhe-nos <br> nas redes sociais</h2>
        <ul class="social-list">
            <li class="social-item"><a href="https://www.facebook.com/ProtestoMA/" class="social-link facebook"><i class="fa fa-facebook" aria-hidden="true"></i><span class="text">ProtestoMA</span></a></li>
            <!-- <li class="social-item"><a href="" class="social-link Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i><span class="text">segundotabeleonatoslz_ma</span></a></li> -->
            <li class="social-item"><a href="https://www.instagram.com/ieptbma" class="social-link instagram"><i class="fa fa-instagram" aria-hidden="true"></i><span class="text">ieptbma</span></a></li>
        </ul>
    </div>
</div>
<div class="localizacao">
    <h2 class="subtitulo">Faça uma visita</h2>
    <address>Av. Daniel de La Touche, 978 - Cohama - Centro Empresarial Shopping da Ilha, Torre 1, 12º Andar, Sala 1211             CEP: 65074-115, São Luís/MA</address>
    <div class="map" id="mapa"></div>
</div>
@stop

@section('scripts')
<script src="{{asset('default/js/maps.js')}}"></script>
@stop
