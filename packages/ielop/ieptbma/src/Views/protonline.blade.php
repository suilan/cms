@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>Protesto Online</li>
    </ul>
</div>
<h2 class="titulo">Protesto Online</h2>
@if(Session::get('status'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('status') }}</li>
        </ul>
    </div>
@endif
<p id="protonline_titulo">Feita para empresas de todos os portes, o <strong style="font-family: Gotham-Bold;">PROTESTO ON-LINE</strong> é  uma ferramenta que proporciona o envio 100% eletrônico de títulos para qualquer Cartório do Estado do Maranhão através da Central de Remessa de Arquivos do Maranhão  (CRA-MA).</p>
<form method="post" action="{{url('protonline')}}" id="protonline_form">
    <input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
    <label for="razao" class="razao">
        <span class="text">Razão Social:</span>
        <input type="text" name="razao" required="true" />
    </label>
    <div style="width: 100%">
        <label for="cnpj" class="cnpj" style="width: 49%; float:left; margin-right: 11px">
            <span class="text">CNPJ:</span>
            <input type="cnpj" name="cnpj" required="true" id="cnpj"/>
        </label>
        <label for="nomeResp" class="nomeResp" style="width: 50%;">
            <span class="text">Nome do Responsável:</span>
            <input type="text" name="nomeResp" required="true" />
        </label>
    </div>
    <div style="width: 100%">
        <label for="email" class="email " style="width: 49%; float:left; margin-right: 11px">
            <span class="text">E-mail:</span>
            <input id="email" type="email" name="email" required="true" />
        </label>
        <label for="telefone" class="telefone1" style="width: 50%;">
            <span class="text">Telefone:</span>
            <input type="text" name="telefone" required="true" id="contato" />
        </label>
    </div>
    <div style="width: 100%">
        <label for="whatsapp" class="whatsapp" style="width: 49%; float:left; margin-right: 11px">
            <span class="text">WhatsApp:</span>
            <input type="text" name="whatsapp" required="true" id="zap"/>
        </label>
        <label for="celular" class="celular" style="width: 50%;">
            <span class="text">Celular:</span>
            <input type="text" name="celular" required="true" id="celular"/>
        </label>
    </div>
    <label for="segmento" class="segmento">
        <span class="text">Segmento:</span>
        <input type="text" name="segmento" required="true" />
    </label>

    <div style="width: 100%; text-align:center; margin-top: 10px">
        <strong class="subtitulo" style="margin: 30px 0 0px;">Informações dos Títulos</strong>
    </div>

    <div style="width: 100%; display: flex; margin-top: 25px">
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">DMI</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="DMI"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">DSI</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="DSI"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">NOTA PROMISSÓRIA</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="NOTA PROMISSÓRIA"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">CBI</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="CBI"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">CONTRATOS</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="CONTRATOS"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">CHEQUE</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="CHEQUE"/>
            </label>
        </div>
        <div style="width: 25%; text-align: -webkit-center;">
            <label for="mensagem" class="mensagem" style="display: inline-flex; justify-content: center; align-items: center;">
                <span class="text">OUTROS</span>
                <input type="checkbox" style="width: -webkit-fill-available;" name="tipoProtesto[]" value="OUTROS"/>
            </label>
        </div>
    </div>

    <div>
        <label for="mensagem" class="mensagem">
            <span class="text">Estimativa mensal de títulos a enviar</span>
            <select name="qtdTitulos" id="qtdTitulos">
                <option value="">--Selecione aqui--</option>
                <option value="De 0 a 99">De 0 a 99</option>
                <option value="De 100 a 500">De 100 a 500</option>
                <option value="De 501 a 999">De 501 a 999</option>
                <option value="Acima de 1000">Acima de 1000</option>
            </select>
        </label>
    </div>

    <label for="mensagem" class="mensagem">
        <span class="text">Quais as formas de cobrança são utilizadas pela empresa para inadimplência? Já Utilizam o protesto?</span>
        <textarea name="mensagem" cols="30" rows="30" required="true" ></textarea>
    </label>
    <button class="bt-enviar">Enviar</button>
    <em class="obs">*Todos os campos são obrigatórios</em>
</form>
<div class="aside">
    {{-- <div class="telefone">
        <h2 class="subtitulo">Ligue para nós</h2>
        <span class="numero"><i class="fa fa-phone" aria-hidden="true"></i> 98 3304 8117</span>
        <br>
        <span class="numero"><i class="fa fa-phone" aria-hidden="true"></i> 98 3304 8119</span>
    </div>
    <div class="telefone">
        <h2 class="subtitulo">E-mail</h2>
        <span class="numero" style="font-size: 22px;"><i class="fa fa-envelope" aria-hidden="true" style="margin-right: 5px"></i>contato@ieptbma.com.br</span>
    </div> --}}
    {{--  <div class="sociais">
        <h2 class="subtitulo">Acompanhe-nos <br> nas redes sociais</h2>
        <ul class="social-list">
            <li class="social-item"><a href="https://www.facebook.com/ProtestoMA/" class="social-link facebook"><i class="fa fa-facebook" aria-hidden="true"></i><span class="text">ProtestoMA</span></a></li>
            <!-- <li class="social-item"><a href="" class="social-link Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i><span class="text">segundotabeleonatoslz_ma</span></a></li> -->
            <li class="social-item"><a href="https://www.instagram.com/ieptbma" class="social-link instagram"><i class="fa fa-instagram" aria-hidden="true"></i><span class="text">ieptbma</span></a></li>
        </ul>
    </div>  --}}
</div>
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#contato").inputmask({"mask": "(99)99999-9999"}); //specifying options
            $("#zap").inputmask({"mask": "(99)99999-9999"}); //specifying options
            $("#celular").inputmask({"mask": "(99)99999-9999"}); //specifying options
            $("#cnpj").inputmask({"mask": "99.999.999/9999-99"}); //specifying options
        });        
    </script>
@stop
