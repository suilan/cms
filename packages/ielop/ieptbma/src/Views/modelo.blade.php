@extends('ieptbma::template.main')

@section('content')
<style>
    input{
        text-transform: uppercase;
    }
    .doc {
        float: left;
        clear: none;
        width: 100%;
    }
    
    .label_doc {
        float: left;
        clear: none;
        display: block;
        margin-bottom: 0px !important;
        padding: 2px 1em 0 0;
    }
    
    input[type=radio]{
        float: left;
        clear: none;
        width: 5% !important;
        height: 28px !important;
        margin: 2px 0 0 2px;
    }
    #img_empresa{
        border-color: #FFFFFF;
        padding: 0;
    }
    
    .has-error { border-color: #F70202 !important;} 
</style>

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>MODELOS DE DOCUMENTOS</li>
    </ul>
</div>
<h2 class="titulo">Modelos de Documentos</h2>
<ol>
    <li class="duvida duv1" id="duv1">
        <h3 class="pergunta perg1">MODELO DE CARTA DE ANUÊNCIA</h3>
        <div class="resposta">
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
                <p style="text-align:center">MODELO DE CARTA DE ANUÊNCIA</p>
                <form id="formAnuencia" method="post" action="{{url('modelos')}}" enctype="multipart/form-data">
                    <input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tipo_modelo" id="cainput_token" name="_token" value="anum">
                    <label for="img_empresa" class="img_empresa">
                        <div class="inscricao_form_left" style="float:left">
                            <label class="label_doc" for="img_empresa">Logo para timbrado</label>
                            <input type="file" name="img_empresa" id="img_empresa"/>
                        </div>
                    </label>
                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf_credor">CPF</label>
                            <input checked type="radio" name="documento_credor" id="doc_cpf_credor" value="cpf"/>
                            <label class="label_doc" for="doc_cnpj_credor">CNPJ</label>
                            <input type="radio" name="documento_credor" id="doc_cnpj_credor" value="cnpj" />
                        </div>
                    </label>
                    <label for="creador" class="creador">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Credor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor" class ="credor" id="credor" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left:20px">
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cnpj" id="cnpj" name="cnpj" style="width: 289px"/>
                        </div>
                    </label>
                    <label for="cep_credor" class="cep_credor">
                        <span class="text">Cep<strong style="color: red">*</strong>:</span></span>
                        <input type="text" name="cep" required="true" class="cep" id = "cep" style="width: 289px"/>
                    </label>
                    <label for="endereco" class="endereco">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Logradouro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="logradouro" class ="logradouro" id="logradouro" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Nº:</span>
                            <input type="text" class= "numero" id="numero" name="numero" style="width: 100px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Complemento:</span>
                            <input type="text" class= "complemento" id="complemento" name="complemento" style="width: 170px"/>
                        </div>
                    </label>
                    <label for="endereco2" class="endereco2">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Bairro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="bairro" class ="bairro" id="bairro" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Cidade<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cidade" id="cidade" name="cidade" style="width: 282px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">UF<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "uf" id="uf" name="uf" style="width: 170px"/>
                        </div>
                    </label>

                    <p style="margin-top: 40px; margin-bottom: 40px">Por seu(s) representante(s) legal(ais) abaixo assinado(s) e qualificado(s), declara ter recebido o pagamento do título adiante descrito, dando plena e 
                        geral quitação do mesmo, autorizando o cancelamento de seu protesto:</p>
                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf">CPF</label>
                            <input checked type="radio" name="documento" id="doc_cpf" value="cpf"/>
                            <label class="label_doc" for="doc_cnpj">CNPJ</label>
                            <input type="radio" name="documento" id="doc_cnpj" value="cnpj" />
                        </div>
                    </label>
                    <label for="devedor" class="devedor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Devedor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="devedor" class ="devdedor" id="devdedor" required="true" style="width: 500px" />
                        </div>
                        
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px"> 
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "documento" id="documento" name="documento" style="width: 289px"/>
                        </div>
                    </label>

                    <label for="titulo1" class="titulo1">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Nº do Título<strong style="color: red">*</strong>:</span>
                            <input type="text" name="num_titulo" class ="num_titulo" id="num_titulo" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Espécie<strong style="color: red">*</strong>:</span></span>
                            <select name="especie" id="especie" class="form-control select2" title="Espécie de Título" style="width: 330px">
                                <option value="">-- Espécie --</option>
                                @foreach($especies as $e)
                                    <option value="{{$e->codigo.' - '.$e->nome}}">{{$e->codigo.' - '.$e->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>

                    <label for="valor" class="valor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Valor do Título<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "valor" id="valor" name="valor" style="width: 170px"/>
                            <input type="hidden" class= "valor_extenso" id="valor_extenso" name="valor_extenso" style="width: 170px"/>
                        </div>
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px; line-height:6; height: 60px;">
                            <p id="numeroExtenso">zero</p>
                        </div>
                    </label>

                    <label for="datas" class="datas">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Data da Emissão do Título<strong style="color: red">*</strong>:</span>
                            <input type="text" name="emissao_titulo" class ="emissao_titulo data" id="emissao_titulo" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Data de Vencimento do Título<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "vencimento_titulo data" id="vencimento_titulo" name="vencimento_titulo" style="width: 296px"/>
                        </div>
                    </label>
                    <button class="bt-enviar">Imprimir</button>
                </form>
            @endif
        </div>
    </li>
    <li class="duvida duv2" id="duv2">
        <h3 class="pergunta perg2">MODELO DE NOTA PROMISSÓRIA</h3>
        <div class="resposta">
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
                <p style="text-align:center">MODELO DE NOTA PROMISSÓRIA</p>
                <form id="formAnuencia" method="post" action="{{url('modelos')}}">
                    <input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tipo_modelo" id="cainput_token" name="_token" value="prom">
                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf_credor">CPF</label>
                            <input checked type="radio" name="documento_credor_prom" id="doc_cpf_credor_prom" value="cpf"/>
                            <label class="label_doc" for="doc_cnpj_credor">CNPJ</label>
                            <input type="radio" name="documento_credor_prom" id="doc_cnpj_credor_prom" value="cnpj" />
                        </div>
                    </label>
                    <label for="creador" class="creador">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Credor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor" class ="credor" id="credor" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left:20px">
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cnpj_prom" id="cnpj_prom" name="cnpj_prom" style="width: 289px"/>
                        </div>
                    </label>

                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf">CPF</label>
                            <input checked type="radio" name="documento" id="doc_cpf_prom" value="cpf"/>
                            <label class="label_doc" for="doc_cnpj">CNPJ</label>
                            <input type="radio" name="documento" id="doc_cnpj_prom" value="cnpj" />
                        </div>
                    </label>
                    <label for="devedor" class="devedor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Devedor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="devedor" class ="devdedor" id="devdedor" required="true" style="width: 500px" />
                        </div>
                        
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px"> 
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "documento_prom" id="documento_prom" name="documento_prom" style="width: 289px"/>
                        </div>
                    </label>

                    <label for="cep_credor" class="cep_credor">
                            <span class="text">Cep<strong style="color: red">*</strong>:</span></span>
                            <input type="text" name="cep_prom" required="true" class="cep_prom" id = "cep_prom" style="width: 289px"/>
                    </label>
                    <label for="endereco" class="endereco">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Logradouro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="logradouro_prom" class ="logradouro_prom" id="logradouro_prom" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Nº:</span>
                            <input type="text" class= "numero" id="numero" name="numero" style="width: 100px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Complemento:</span>
                            <input type="text" class= "complemento" id="complemento" name="complemento" style="width: 170px"/>
                        </div>
                    </label>
                    <label for="endereco2" class="endereco2">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Bairro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="bairro_prom" class ="bairro_prom" id="bairro_prom" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Cidade<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cidade_prom" id="cidade_prom" name="cidade_prom" style="width: 330px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">UF<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "uf_prom" id="uf_prom" name="uf_prom" style="width: 170px"/>
                        </div>
                    </label>

                    <label for="titulo1" class="titulo1">
                        <div class="inscricao_form_left" style="float: left; width: 100%">
                            <span class="text">Local do Pagamento: (Deixar em branco para preenchimento automático)</span>
                            <input type="text" name="local_pgto" class ="local_pgto" id="local_pgto" />
                        </div>
                    </label>

                    <label for="valor" class="valor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Valor Total<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "valor_prom" id="valor_prom" name="valor_prom" style="width: 170px"/>
                            <input type="hidden" class= "valor_extenso_prom" id="valor_extenso_prom" name="valor_extenso_prom" style="width: 170px"/>
                        </div>
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px; line-height:6; height: 60px;">
                            <p id="numeroExtensoProm">zero</p>
                        </div>
                    </label>

                    <label for="datas" class="datas">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Nº de Parcelas<strong style="color: red">*</strong>:</span>
                            <input type="text" name="num_parcelas" class ="num_parcelas" id="num_parcelas" required="true" style="width: 170px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px">
                            <span class="text">Data de Vencimento<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "vencimento_titulo data" id="vencimento_titulo" name="vencimento_titulo" style="width: 296px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Vencimento a cada quantos dias?<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "qtd_dias" id="qtd_dias" name="qtd_dias" style="width: 170px"/>
                        </div>
                    </label>
                    <p style="margin-top: 30px; margin-bottom:30px;">Caso Hajam  avalistas, favor informar.</p>
                    {{--  Avaistas  --}}
                    <label for="avalista1" class="avalista1">
                            <div class="doc inscricao_form_right" style="float:right">
                                <label class="label_doc" for="doc_cpf">CPF</label>
                                <input checked type="radio" name="documento_avalista1" id="doc_cpf_avalista1" value="cpf"/>
                                <label class="label_doc" for="doc_cnpj">CNPJ</label>
                                <input type="radio" name="documento_avalista1" id="doc_cnpj_avalista1" value="cnpj" />
                            </div>
                        </label>
                        <label for="avalista1" class="avalista1">
                            <div class="inscricao_form_left" style="float: left;">
                                <span class="text">Avalista 1:</span>
                                <input type="text" name="avalista1" class ="avalista1" id="avalista1"  style="width: 500px" />
                            </div>
                            
                            <div class="inscricao_form_left" style="float: left; margin-left: 20px"> 
                                <span class="text">CPF/CNPJ:</span></span>
                                <input type="text" class= "cnpj_avalista1" id="cnpj_avalista1" name="cnpj_avalista1" style="width: 289px"/>
                            </div>
                        </label>

                        <label for="cep_avalista" class="cep_avalista">
                                <span class="text">Cep:</span></span>
                                <input type="text" name="cep_avalista1"  class="cep_avalista1" id="cep_avalista1" style="width: 289px"/>
                        </label>
                        <label for="endereco" class="endereco">
                            <div class="inscricao_form_left" style="float: left;">
                                <span class="text">Logradouro:</span>
                                <input type="text" name="logradouro_avalista1" class ="logradouro_avalista1" id="logradouro_avalista1"  style="width: 500px" />
                            </div>
        
                            <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                                <span class="text">Nº:</span>
                                <input type="text" class= "numero_avalista1" id="numero_avalista1" name="numero_avalista1" style="width: 100px"/>
                            </div>

                            <div class="inscricao_form_left" style="float: left;">
                                <span class="text">Complemento:</span>
                                <input type="text" class= "complemento_avalista1" id="complemento_avalista1" name="complemento_avalista1" style="width: 170px"/>
                            </div>
                        </label>
                        <label for="endereco2" class="endereco2">
                            <div class="inscricao_form_left" style="float: left;">
                                <span class="text">Bairro:</span>
                                <input type="text" name="bairro_avalista1" class ="bairro_avalista1" id="bairro_avalista1"  style="width: 320px" />
                            </div>
        
                            <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                                <span class="text">Cidade:</span></span>
                                <input type="text" class= "cidade_avalista1" id="cidade_avalista1" name="cidade_avalista1" style="width: 281px"/>
                            </div>

                            <div class="inscricao_form_left" style="float: left;">
                                <span class="text">UF:</span></span>
                                <input type="text" class= "uf_avalista1" id="uf_avalista1" name="uf_avalista1" style="width: 170px"/>
                            </div>
                        </label>

                        {{--  Avalista 2  --}}
                        <label for="avalista2" class="avalista2">
                                <div class="doc inscricao_form_right" style="float:right">
                                    <label class="label_doc" for="doc_cpf">CPF</label>
                                    <input checked type="radio" name="documento_avalista2" id="doc_cpf_avalista2" value="cpf"/>
                                    <label class="label_doc" for="doc_cnpj">CNPJ</label>
                                    <input type="radio" name="documento_avalista2" id="doc_cnpj_avalista2" value="cnpj" />
                                </div>
                            </label>
                            <label for="avalista2" class="avalista2">
                                <div class="inscricao_form_left" style="float: left;">
                                    <span class="text">Avalista 2:</span>
                                    <input type="text" name="avalista2" class ="avalista2" id="avalista2"  style="width: 500px" />
                                </div>
                                
                                <div class="inscricao_form_left" style="float: left; margin-left: 20px"> 
                                    <span class="text">CPF/CNPJ:</span></span>
                                    <input type="text" class= "cnpj_avalista2" id="cnpj_avalista2" name="cnpj_avalista2" style="width: 289px"/>
                                </div>
                            </label>

                            <label for="cep_avalista" class="cep_avalista">
                                    <span class="text">Cep:</span></span>
                                    <input type="text" name="cep_avalista2"  class="cep_avalista2" id="cep_avalista2" style="width: 289px"/>
                            </label>
                            <label for="endereco" class="endereco">
                                <div class="inscricao_form_left" style="float: left;">
                                    <span class="text">Logradouro:</span>
                                    <input type="text" name="logradouro_avalista2" class ="logradouro_avalista2" id="logradouro_avalista2"  style="width: 500px" />
                                </div>
            
                                <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                                    <span class="text">Nº:</span>
                                    <input type="text" class= "numero_avalista2" id="numero_avalista2" name="numero_avalista2" style="width: 100px"/>
                                </div>

                                <div class="inscricao_form_left" style="float: left;">
                                    <span class="text">Complemento:</span>
                                    <input type="text" class= "complemento_avalista2" id="complemento_avalista2" name="complemento_avalista2" style="width: 170px"/>
                                </div>
                            </label>
                            <label for="endereco2" class="endereco2">
                                <div class="inscricao_form_left" style="float: left;">
                                    <span class="text">Bairro:</span>
                                    <input type="text" name="bairro_avalista2" class ="bairro_avalista2" id="bairro_avalista2"  style="width: 320px" />
                                </div>
            
                                <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                                    <span class="text">Cidade:</span></span>
                                    <input type="text" class= "cidade_avalista2" id="cidade_avalista2" name="cidade_avalista2" style="width: 281px"/>
                                </div>

                                <div class="inscricao_form_left" style="float: left;">
                                    <span class="text">UF:</span></span>
                                    <input type="text" class= "uf_avalista2" id="uf_avalista2" name="uf_avalista2" style="width: 170px"/>
                                </div>
                            </label>
                    <button class="bt-enviar">Imprimir</button>
                </form>
            @endif
        </div>
    </li>
    <li class="duvida duv3" id="duv3">
        <h3 class="pergunta perg3">MODELO DE REQUERIMENTO PARA DESISTÊNCIA</h3>
        <div class="resposta">
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
                <p style="text-align:center">MODELO DE REQUERIMENTO PARA DESISTÊNCIA</p>
                <form id="formAnuencia" method="post" action="{{url('modelos')}}" enctype="multipart/form-data">
                    <input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tipo_modelo" id="cainput_token" name="_token" value="desist">
                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf_desist">CPF</label>
                            <input checked type="radio" name="documento_desist" id="doc_cpf_desist" value="cpf"/>

                            <label class="label_doc" for="doc_cnpj_desist">CNPJ</label>
                            <input type="radio" name="documento_desist" id="doc_cnpj_desist" value="cnpj" />
                        </div>
                    </label>
                    <label for="creador" class="creador">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Credor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor_desist" class ="credor_desist" id="credor_desist" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left:20px">
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cred_cnpj_desist" id="cred_cnpj_desist" name="cred_cnpj_desist" style="width: 289px"/>
                        </div>
                    </label>
                    <label for="creador_nac" class="creador_nac">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Nacionalidade<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor_nac" class ="credor_nac" id="credor_nac" required="true" style="width: 250px" />
                        </div>

                        <div class="inscricao_form_left" style="float: left; margin-left: 20px">
                            <span class="text">Estado Civil<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor_civil" class ="credor_civil" id="credor_civil" required="true" style="width: 250px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left:20px">
                            <span class="text">RG<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "rg" id="rg" name="rg" style="width: 270px"/>
                        </div>
                    </label>
                    <label for="creador_prof" class="creador_prof">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Profissão<strong style="color: red">*</strong>:</span>
                            <input type="text" name="credor_prof" class ="credor_prof" id="credor_prof" required="true" style="width: 289px" />
                        </div>
                    </label>
                    <label for="cep_credor" class="cep_credor">
                        <span class="text">Cep<strong style="color: red">*</strong>:</span></span>
                        <input type="text" name="cep_desist" required="true" class="cep_desist" id = "cep_desist" style="width: 289px"/>
                    </label>
                    <label for="endereco" class="endereco">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Logradouro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="logradouro_desist" class ="logradouro_desist" id="logradouro_desist" required="true" style="width: 500px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Nº:</span>
                            <input type="text" class= "numero_desist" id="numero_desist" name="numero_desist" style="width: 100px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Complemento:</span>
                            <input type="text" class= "complemento_desist" id="complemento_desist" name="complemento_desist" style="width: 170px"/>
                        </div>
                    </label>
                    <label for="endereco2" class="endereco2">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Bairro<strong style="color: red">*</strong>:</span>
                            <input type="text" name="bairro_desist" class ="bairro_desist" id="bairro_desist" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Cidade<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "cidade_desist" id="cidade_desist" name="cidade_desist" style="width: 282px"/>
                        </div>

                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">UF<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "uf_desist" id="uf_desist" name="uf_desist" style="width: 170px"/>
                        </div>
                    </label>

                    <p style="margin-top: 40px; margin-bottom: 40px">Abaixo, informe os dados do Título que deseja <strong style="text-decoration: underline;">desistência</strong>:</p>

                    <label for="devedor" class="devedor">
                        <div class="doc inscricao_form_right" style="float:right">
                            <label class="label_doc" for="doc_cpf">CPF</label>
                            <input checked type="radio" name="documento_desist_dev" id="doc_cpf_desist_num" value="cpf"/>
                            <label class="label_doc" for="doc_cnpj">CNPJ</label>
                            <input type="radio" name="documento_desist_dev" id="doc_cnpj_desist_num" value="cnpj" />
                        </div>
                    </label>
                    <label for="devedor" class="devedor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Devedor<strong style="color: red">*</strong>:</span>
                            <input type="text" name="devedor_desist" class ="devedor_desist" id="devedor_desist" required="true" style="width: 500px" />
                        </div>
                        
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px"> 
                            <span class="text">CPF/CNPJ<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "documento_desist_num" id="documento_desist_num" name="documento_desist_num" style="width: 289px"/>
                        </div>
                    </label>

                    <label for="protocolo" class="protocolo">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Nº do Protocolo<strong style="color: red">*</strong>:</span>
                            <input type="text" name="num_protocolo" class ="num_protocolo" id="num_protocolo" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px">
                            <span class="text">Data do Protocolo<strong style="color: red">*</strong>:</span>
                            <input type="text" name="data_protocolo" class ="data_protocolo data" id="data_protocolo" required="true" style="width: 320px" />
                        </div>
                    </label>

                    <label for="titulo1" class="titulo1">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Nº do Título<strong style="color: red">*</strong>:</span>
                            <input type="text" name="num_titulo_desist" class ="num_titulo_desist" id="num_titulo_desist" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Espécie<strong style="color: red">*</strong>:</span></span>
                            <select name="especie_desist" id="especie_desist" class="form-control select2" title="Espécie de Título" style="width: 330px">
                                <option value="">-- Espécie --</option>
                                @foreach($especies as $e)
                                    <option value="{{$e->codigo.' - '.$e->nome}}">{{$e->codigo.' - '.$e->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>

                    <label for="valor" class="valor">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Valor do Título<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "valor_desist" id="valor_desist" name="valor_desist" style="width: 170px"/>
                            <input type="hidden" class= "valor_extenso_desist" id="valor_extenso_desist" name="valor_extenso_desist" style="width: 170px"/>
                        </div>
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px; line-height:6; height: 60px;">
                            <p id="numeroExtensoDesist">zero</p>
                        </div>
                    </label>

                    <label for="datas" class="datas">
                        <div class="inscricao_form_left" style="float: left;">
                            <span class="text">Data da Emissão do Título<strong style="color: red">*</strong>:</span>
                            <input type="text" name="emissao_titulo_desist" class ="emissao_titulo_desist data" id="emissao_titulo_desist" required="true" style="width: 320px" />
                        </div>
    
                        <div class="inscricao_form_left" style="float: left; margin-left: 20px; margin-right: 20px">
                            <span class="text">Data de Vencimento do Título<strong style="color: red">*</strong>:</span></span>
                            <input type="text" class= "vencimento_titulo_desist data" id="vencimento_titulo_desist" name="vencimento_titulo_desist" style="width: 296px"/>
                        </div>
                    </label>
                    <button class="bt-enviar">Imprimir</button>
                </form>
            @endif
        </div>
    </li>
</ol>
@stop
@include('ieptbma::template._scripts')
@section('scripts')
<script>
    $(document).ready(function() {
        $('.perg1').click(function(event) {
            if ( $('.duv2').hasClass('show') ) {
                $('.duv2').removeClass('show');
            }
            if ( $('.duv3').hasClass('show') ) {
                $('.duv3').removeClass('show');
            }

            if ( $('.duv1').hasClass('show') ) {
                $('.duv1').removeClass('show');
            } else {
                $('.duv1').removeClass('show');
                $('.duv1').addClass('show');
            }

            EPPZScrollTo.scrollVerticalToElementById('duv1', 20);
        });
    });

    $(document).ready(function() {
        $('.perg2').click(function(event) {
            if ( $('.duv1').hasClass('show') ) {
                $('.duv1').removeClass('show');
            }
            if ( $('.duv3').hasClass('show') ) {
                $('.duv3').removeClass('show');
            }

            if ( $('.duv2').hasClass('show') ) {
                $('.duv2').removeClass('show');
            } else {
                $('.duv2').removeClass('show');
                $('.duv2').addClass('show');
            }

            EPPZScrollTo.scrollVerticalToElementById('duv2', 20);
        });
    });

    $(document).ready(function() {
        $('.perg3').click(function(event) {
            if ( $('.duv1').hasClass('show') ) {
                $('.duv1').removeClass('show');
            }
            if ( $('.duv2').hasClass('show') ) {
                $('.duv2').removeClass('show');
            }

            if ( $('.duv3').hasClass('show') ) {
                $('.duv3').removeClass('show');
            } else {
                $('.duv3').removeClass('show');
                $('.duv3').addClass('show');
            }

            EPPZScrollTo.scrollVerticalToElementById('duv3', 20);
        });
    });
</script>

<script src="{{asset('ieptbma/js/extenso.js')}}"></script>
    <script>
        function limpa_formulário_cep(grupo) {
            // Limpa valores do formulário de cep.
            $(".logradouro."+grupo).val("");
            $(".bairro."+grupo).val("");
            $(".cidade."+grupo).val("");
        }

        function limpa_formulário_cep_prom(grupo) {
            // Limpa valores do formulário de cep.
            $(".logradouro_prom."+grupo).val("");
            $(".bairro_prom."+grupo).val("");
            $(".cidade_prom."+grupo).val("");
        }

        function limpa_formulário_cep_desist(grupo) {
            // Limpa valores do formulário de cep.
            $(".logradouro_desist."+grupo).val("");
            $(".bairro_desist."+grupo).val("");
            $(".cidade_desist."+grupo).val("");
        }

        function limpa_formulário_cep_avalista1(grupo) {
            // Limpa valores do formulário de cep.
            $(".logradouro_avalista1."+grupo).val("");
            $(".bairro_avalista1."+grupo).val("");
            $(".cidade_avalista1."+grupo).val("");
        }

        function limpa_formulário_cep_avalista2(grupo) {
            // Limpa valores do formulário de cep.
            $(".logradouro_avalista2."+grupo).val("");
            $(".bairro_avalista2."+grupo).val("");
            $(".cidade_avalista2."+grupo).val("");
        }
        
        $(".cep").inputmask("99.999-999");
        $(".data").inputmask("99/99/9999");
        $(".documento").inputmask("999.999.999-99");
        $(".cnpj").inputmask("999.999.999-99");

        $(".cep_prom").inputmask("99.999-999");
        $(".data_prom").inputmask("99/99/9999");
        $(".documento_prom").inputmask("999.999.999-99");
        $(".cnpj_prom").inputmask("999.999.999-99");

        $(".cep_avalista1").inputmask("99.999-999");
        $(".cnpj_avalista1").inputmask("999.999.999-99");

        $(".cep_avalista2").inputmask("99.999-999");
        $(".cnpj_avalista2").inputmask("999.999.999-99");

        $(".cep_desist").inputmask("99.999-999");
        $(".cred_cnpj_desist").inputmask("999.999.999-99");
        $(".documento_desist_num").inputmask("999.999.999-99");
        
        $('input[type=radio][name=documento]').change(function() {
            if (this.value == 'cpf') {
                $(".documento").inputmask("999.999.999-99");
            } else {
                $(".documento").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_credor]').change(function() {
            if (this.value == 'cpf') {
                $(".cnpj").inputmask("999.999.999-99");
            } else {
                $(".cnpj").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_prom]').change(function() {
            if (this.value == 'cpf') {
                $(".documento_prom").inputmask("999.999.999-99");
            } else {
                $(".documento_prom").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_credor_prom]').change(function() {
            if (this.value == 'cpf') {
                $(".cnpj_prom").inputmask("999.999.999-99");
            } else {
                $(".cnpj_prom").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_avalista1]').change(function() {
            if (this.value == 'cpf') {
                $(".cnpj_avalista1").inputmask("999.999.999-99");
            } else {
                $(".cnpj_avalista1").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_avalista2]').change(function() {
            if (this.value == 'cpf') {
                $(".cnpj_avalista2").inputmask("999.999.999-99");
            } else {
                $(".cnpj_avalista2").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_desist]').change(function() {
            if (this.value == 'cpf') {
                $(".cred_cnpj_desist").inputmask("999.999.999-99");
            } else {
                $(".cred_cnpj_desist").inputmask("99.999.999/9999-99");
            }
        });

        $('input[type=radio][name=documento_desist_dev]').change(function() {
            if (this.value == 'cpf') {
                $(".documento_desist_num").inputmask("999.999.999-99");
            } else {
                $(".documento_desist_num").inputmask("99.999.999/9999-99");
            }
        });

        $('#cnpj').blur(function() {
            if( this.value !=''  ){
                if($('#doc_cpf_credor').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#cnpj_prom').blur(function() {
            if( this.value !=''  ){
                if($('#doc_cpf_credor_prom').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#documento').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#documento_prom').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf_prom').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#cnpj_avalista1').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf_avalista1').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#cnpj_avalista2').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf_avalista2').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#cred_cnpj_desist').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf_desist').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });

        $('#documento_desist_num').blur(function() { 
            if( this.value !=''  ){
                if($('#doc_cpf_desist_num').val()=='cpf'){
                    if(validarCpf(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
                else{
                    if(validarCNPJ(this.value)){
                        $(this).removeClass('has-error');
                    }
                    else{
                        $(this).addClass('has-error');
                        return false;
                    }
                }
            }
        });



        $( document ).ready(function() {
            $('#numeroExtenso').text(extenso($('#valor').value.replace('R$ ','')));
            $('#valor_extenso').val(extenso($('#valor').value.replace('R$ ','')));

            $('#numeroExtensoProm').text(extenso($('#valor_prom').value.replace('R$ ','')));
            $('#valor_extenso_prom').val(extenso($('#valor_prom').value.replace('R$ ','')));

            $('#numeroExtensoDesist').text(extenso($('#valor_desist').value.replace('R$ ','')));
            $('#valor_extenso_desist').val(extenso($('#valor_desist').value.replace('R$ ','')));
        });

        // Money mask
        $('#valor,#saldo,#custas').keyup(function() {
            $('#numeroExtenso').text(extenso(this.value.replace('R$ ','')));
            $('#valor_extenso').val(extenso(this.value.replace('R$ ','')));
        });

        $('#valor_prom').keyup(function() {
            $('#numeroExtensoProm').text(extenso(this.value.replace('R$ ','')));
            $('#valor_extenso_prom').val(extenso(this.value.replace('R$ ','')));
        });

        $('#valor_desist').keyup(function() {
            $('#numeroExtensoDesist').text(extenso(this.value.replace('R$ ','')));
            $('#valor_extenso_desist').val(extenso(this.value.replace('R$ ','')));
        });

        $("#valor").inputmask('decimal', {
            radixPoint:",",
            groupSeparator: ".",
            autoGroup: true,
            digits: 2,
            digitsOptional: true,
            numericInput: true,
            placeholder: '0',
            rightAlign: true,
            onBeforeMask: function (value, opts) {
                return value;
            }
        });

        $("#valor_prom").inputmask('decimal', {
            radixPoint:",",
            groupSeparator: ".",
            autoGroup: true,
            digits: 2,
            digitsOptional: true,
            numericInput: true,
            placeholder: '0',
            rightAlign: true,
            onBeforeMask: function (value, opts) {
                return value;
            }
        });

        $("#valor_desist").inputmask('decimal', {
            radixPoint:",",
            groupSeparator: ".",
            autoGroup: true,
            digits: 2,
            digitsOptional: true,
            numericInput: true,
            placeholder: '0',
            rightAlign: true,
            onBeforeMask: function (value, opts) {
                return value;
            }
        });

        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
        
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
        
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
        
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
        
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro").val("...")
                    $("#bairro").val("...")
                    $("#cidade").val("...")
        
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });

        $("#cep_prom").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
        
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
        
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
        
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
        
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro_prom").val("...")
                    $("#bairro_prom").val("...")
                    $("#cidade_prom").val("...")
        
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro_prom").val(dados.logradouro);
                            $("#bairro_prom").val(dados.bairro);
                            $("#cidade_prom").val(dados.localidade);
                            $("#uf_prom").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep_prom();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep_prom();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep_prom();
            }
        });

        $("#cep_avalista1").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
        
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
        
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
        
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
        
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro_avalista1").val("...")
                    $("#bairro_avalista1").val("...")
                    $("#cidade_avalista1").val("...")
        
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro_avalista1").val(dados.logradouro);
                            $("#bairro_avalista1").val(dados.bairro);
                            $("#cidade_avalista1").val(dados.localidade);
                            $("#uf_avalista1").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep_prom();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep_prom();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep_prom();
            }
        });

        $("#cep_avalista2").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
        
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
        
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
        
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
        
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro_avalista2").val("...")
                    $("#bairro_avalista2").val("...")
                    $("#cidade_avalista2").val("...")
        
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro_avalista2").val(dados.logradouro);
                            $("#bairro_avalista2").val(dados.bairro);
                            $("#cidade_avalista2").val(dados.localidade);
                            $("#uf_avalista2").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep_prom();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep_prom();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep_prom();
            }
        });

        $("#cep_desist").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
        
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
        
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
        
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
        
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro_desist").val("...")
                    $("#bairro_desist").val("...")
                    $("#cidade_desist").val("...")
        
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro_desist").val(dados.logradouro);
                            $("#bairro_desist").val(dados.bairro);
                            $("#cidade_desist").val(dados.localidade);
                            $("#uf_desist").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep_prom();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep_prom();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep_prom();
            }
        });

        function validarCpf(strCPF) {
            var Soma;
            var Resto;
            Soma = 0;
            strCPF = strCPF.replace(/[./-]/g,'');
        
            if (strCPF == "00000000000") return false;
        
            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
        
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
        
            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
        
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
        }
        
        function validarCNPJ(cnpj) {
        
            cnpj = cnpj.replace(/[^\d]+/g,'');
        
            if(cnpj == '') return false;
        
            if (cnpj.length != 14)
                return false;
        
            // Elimina CNPJs invalidos conhecidos
            if (cnpj == "00000000000000" ||
                cnpj == "11111111111111" ||
                cnpj == "22222222222222" ||
                cnpj == "33333333333333" ||
                cnpj == "44444444444444" ||
                cnpj == "55555555555555" ||
                cnpj == "66666666666666" ||
                cnpj == "77777777777777" ||
                cnpj == "88888888888888" ||
                cnpj == "99999999999999")
                return false;
        
            // Valida DVs
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
        
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                    return false;
        
            return true;
        }
    </script>

    <script>
        var EPPZScrollTo =
    {
        /**
        * Helpers.
        */
        documentVerticalScrollPosition: function()
        {
            if (self.pageYOffset) return self.pageYOffset; // Firefox, Chrome, Opera, Safari.
            if (document.documentElement && document.documentElement.scrollTop) return document.documentElement.scrollTop; // Internet Explorer 6 (standards mode).
            if (document.body.scrollTop) return document.body.scrollTop; // Internet Explorer 6, 7 and 8.
            return 0; // None of the above.
        },

        viewportHeight: function()
        { return (document.compatMode === "CSS1Compat") ? document.documentElement.clientHeight : document.body.clientHeight; },

        documentHeight: function()
        { return (document.height !== undefined) ? document.height : document.body.offsetHeight; },

        documentMaximumScrollPosition: function()
        { return this.documentHeight() - this.viewportHeight(); },

        elementVerticalClientPositionById: function(id)
        {
            var element = document.getElementById(id);
            var rectangle = element.getBoundingClientRect();
            return rectangle.top;
        },

        /**
        * Animation tick.
        */
        scrollVerticalTickToPosition: function(currentPosition, targetPosition)
        {
            var filter = 0.2;
            var fps = 60;
            var difference = parseFloat(targetPosition) - parseFloat(currentPosition);

            // Snap, then stop if arrived.
            var arrived = (Math.abs(difference) <= 0.5);
            if (arrived)
            {
                // Apply target.
                scrollTo(0.0, targetPosition);
                return;
            }

            // Filtered position.
            currentPosition = (parseFloat(currentPosition) * (1.0 - filter)) + (parseFloat(targetPosition) * filter);

            // Apply target.
            scrollTo(0.0, Math.round(currentPosition));

            // Schedule next tick.
            setTimeout("EPPZScrollTo.scrollVerticalTickToPosition("+currentPosition+", "+targetPosition+")", (1000 / fps));
        },

        /**
        * For public use.
        *
        * @param id The id of the element to scroll to.
        * @param padding Top padding to apply above element.
        */
        scrollVerticalToElementById: function(id, padding)
        {
            var element = document.getElementById(id);
            if (element == null)
            {
                console.warn('Cannot find element with id \''+id+'\'.');
                return;
            }

            var targetPosition = this.documentVerticalScrollPosition() + this.elementVerticalClientPositionById(id) - padding;
            var currentPosition = this.documentVerticalScrollPosition();

            // Clamp.
            var maximumScrollPosition = this.documentMaximumScrollPosition();
            if (targetPosition > maximumScrollPosition) targetPosition = maximumScrollPosition;

            // Start animation.
            this.scrollVerticalTickToPosition(currentPosition, targetPosition);
        }
    };
    </script>
@stop