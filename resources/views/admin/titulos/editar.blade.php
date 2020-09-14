@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<style type="text/css">input[type='text']{text-transform: uppercase!important;}</style>
<link rel="stylesheet" href="{{asset('admin/plugins/select2/select2.min.css')}}">
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="titulo pull-left">{{$registro->protocolo?'Protocolo: '.$registro->protocolo:'Novo Título'}}</h2>
                <h2 class="titulo pull-right">{{$registro->protocolo?'Protocolo: '.$registro->protocolo:'Remessa - '}}{{$remessa}}</h2>
            </div>
            @include('admin.template.alerts')
            <!-- /.box-header -->
            <form action="{{url('admin/titulos'.($registro->id?'/'.$registro->id:''))}}" id="form_registro" method="post">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="remessa" value="{{ Input::get('remessa') }}">
                    @if( Request::segment(3)!="create" )
		            <input type="hidden" name="_method" value="put">
                    @endif

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                @if( $isAdmin )
                                    <label>Cartório</label>
                                    <select name="cartorio" id="cartorio" class="form-control select2" title="Cartório">
                                        <option value="">-- Cartório --</option>
                                        @foreach($cartorios as $c)
                                            <option value="{{$c->id}}">{{$c->cidade}} - {{$c->nome}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="tipo-documento" class="control-label pull-left">DADOS DO SACADO/DEVEDOR</label>
                                <div class="checkbox">
                                    <label class="pull-right"><input type="checkbox" name="fixardevedor" id="fixar" {{Session::has('devedorId')?'checked':''}}>Fixar Devedor</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="tipo-doc" style="font-weight:normal;">Tipo de Documento</label>
                                <input type="hidden" name="devedor" id="devedor" value="{{$registro->devedor_id}}">
                                <select class="form-control" name="tipo-doc" id="tipo-doc" title="Tipo de Documento">
                                    <option value="1" {{$registro->tipo_doc!=2?'selected':''}}>CPF</option>
                                    <option value="2" {{$registro->tipo_doc==2?'selected':''}}>CNPJ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="documento" style="font-weight:normal;">Documento</label>
                                <input type="text" name="documento" id="documento" title="Documento" placeholder="Documento" class="form-control cpf-mask" value="{{$registro->documento}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nome" style="font-weight:normal;">Nome</label>
                                <input type="text" name="nome" id="nome" placeholder="Nome" title="Nome" class="form-control upper" value="{{$registro->nome}}" >
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="tipo-documento" class="control-label pull-left">ENDEREÇO</label>
                            </div>
                        </div>
                    </div>
                    <div class="row novo-devedor">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cep" style="font-weight:normal;">CEP</label>
                                <input type="text" placeholder="CEP" name="cep" id="cep" data-grupo="devedor" title="CEP" class="form-control cep" value="{{$registro->cep}}" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="logradouro" style="font-weight:normal;">Endereço
                                    <!-- <a class="bt-editar btn-xs btn-default {{$registro->devedor_id?'':'hidden'}}" ><i class="fa fa-edit"></i> Editar</a> -->
                                </label>
                                <input type="text" placeholder="Endereço" name="logradouro" title="Endereço" id="logradouro" class="form-control endereco devedor upper" value="{{$registro->endereco}}" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="numero"  style="font-weight:normal;">Número</label>
                                <input type="text" placeholder="Número" name="numero" title="Número" id="numero" class="form-control" value="{{$registro->numero}}" {{$registro->numero?'readonly':''}}>
                            </div>
                        </div>
                    </div>
                    <div class="row novo-devedor">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cidade"  style="font-weight:normal;">Cidade</label>
                                <input type="hidden" name="cidadeIBGE" id="cidadeIBGE" class="devedor ibge upper" value="{{$registro->ibge}}">
                                <input type="text" placeholder="Cidade" name="cidade" id="cidade" title="Cidade" class="cidade devedor form-control upper" value="{{$registro->cidade}}" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="bairro" style="font-weight:normal;">Bairro</label>
                                <input type="text" placeholder="Bairro" name="bairro" id="bairro" title="Bairro" class="form-control bairro devedor upper" value="{{$registro->bairro}}" >
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-8">
                            <label class="control-label disabled">DADOS DO TÍTULO</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="apresentante" style="font-weight:normal;">Apresentante</label>
                                <input type="text" name="apresentante" id="apresentante" title="Apresentante" placeholder="Apresentante" class="form-control" value="{{$registro->apresentante}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cedente" style="font-weight:normal;">Cedente/Favorecido</label>
                                <input type="text" name="cedente" id="cedente" title="Cedente/Favorecido" placeholder="Cedente/Favorecido" class="form-control" value="{{$registro->cedente}}">
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="protocolo" style="font-weight:normal;">Protocolo</label>
                                <input type="text" name="protocolo" id="protocolo" title="Protocolo" placeholder="Protocolo" class="form-control somenteNumero" value="{{$registro->protocolo}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="nossonumero" style="font-weight:normal;">Nosso Número</label>
                                <input type="text" name="nossonumero" id="nossonumero" title="Nosso Número" placeholder="Nosso Número" class="form-control" value="{{$registro->nosso_numero}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="numero_titulo" style="font-weight:normal;">Nº Título</label>
                                <input type="text" name="numero-titulo" id="numero_titulo" title="Número do Título" placeholder="Número do Título" class="form-control" value="{{$registro->numero_titulo}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label style="font-weight:normal;">Praça</label>
                                <input class="form-control" name="readonly-praca" title="Praça" value="Cartório" readonly>
                                <input type="hidden" name="praca" value="1">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="valor" style="font-weight:normal;">Valor</label>
                                <input type="text" name="valor" id="valor" title="Valor" placeholder="Valor" class="form-control" value="{{$registro->valor}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="custas" style="font-weight:normal;" title="Custas e Emolumentos">Custas e Emolumentos</label>
                                <input type="text" name="custas" id="custas" title="Custas e Emolumentos" placeholder="Custos e Emolumentos" class="form-control" value="{{$registro->custas}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="saldo" style="font-weight:normal;">Total do Título</label>
                                <input type="text" name="saldo" id="saldo" title="Total do Título" placeholder="Total do Título" class="form-control" value="{{$registro->saldo}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label style="font-weight:normal;display:block;">Fins Falimentares?</label>
                                <div class="radio" style="display:initial;">
                                    <label><input type="radio" name="fimfalimentar" class="fimfalimentar" value="0" {{!$registro->fim_falimentar?'checked':''}}>Não</label>
                                </div>
                                <div class="radio" style="display:initial;margin-left:10px;">
                                    <label><input type="radio" name="fimfalimentar" class="fimfalimentar" value="1" {{$registro->fim_falimentar?'checked':''}}>Sim</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="emissao" style="font-weight:normal;">Data de Emissão</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="emissao" id="emissao" title="Data de Emissão" placeholder="Data Emissão" class="form-control datepicker" value="{{$registro->emissao}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="tipo_vencimento" style="font-weight:normal;" title="Vencimento do Apresentante">Venc. do Apresentante</label>
                                <select name="tipo-vencimento" id="tipo_vencimento" title="Tipo de Vencimento" class="form-control tipo-vencimento {{$registro->tipo_vencimento_id!=1?'':'hidden'}}">
                                    <option value="">-- Tipo de Vencimento --</option>
                                    <option value="1" > Inserir Manualmente </option>
                                    <option value="2" {{$registro->tipo_vencimento_id==2?'selected':''}} >À Vista</option>
                                </select>
                                <div class="input-group data-vencimento {{$registro->tipo_vencimento_id==1?'':'hidden'}}">
                                    <div class="input-group-addon" style="color:#fff;background-color:#367fa9;">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="vencimento" id="vencimento" title="Data de Vencimento" placeholder="Data Vencimento" class="form-control datepicker" value="{{$registro->vencimento}}">
                                    <div class="input-group-addon data-vencimento-close" style="color:#fff;background-color:#367fa9;">
                                        <i class="fa fa-close"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">                         
                            <div class="form-group">
                                <label for="endosso" style="font-weight:normal;">Tipos de Endosso</label>
                                <select name="endosso" id="endosso" class="form-control select2" title="Tipo de Endosso">
                                    <option value="">-- Endosso --</option>
                                    @foreach($endossos as $e)
                                        <option value="{{$e->id}}" {{$registro->endosso_id==$e->id?'selected':''}} >{{$e->id.' - '.$e->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">

                        <div class="col-sm-8">     
                            <div class="form-group">
                                <label for="especie" style="font-weight:normal;">Espécie</label>
                                <select name="especie" id="especie" class="form-control select2" title="Espécie de Título">
                                    <option value="">-- Espécie --</option>
                                    @foreach($especies as $e)
                                        <option value="{{$e->id}}" {{$registro->especie_id==$e->id?'selected':''}}>{{$e->codigo.' - '.$e->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        @if( Request::segment(4)=="edit")
                        <button type="submit" class="btn btn-primary" value="1"><i class="fa fa-save"></i> Salvar</button>
                        @else
                        <button type="submit" name="edit" class="btn btn-success"><i class="fa fa-th-list"></i> Salvar e Fechar Remessa </button>
                        <button type="submit" name="novo" class="btn btn-primary" value="1"><i class="fa fa-save"></i> Salvar e Novo</button>
                        @endif
                    </div>
			        <a href="{{url('admin/remessas')}}" class="btn btn-danger"><i class="fa fa-times"></i> Descartar</a>
                </div>
            </form>
        <!-- /.box-footer -->
        </div>
    <!-- /. box -->
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">url = "{{url('admin/titulos/devedor')}}"</script>
<script src="{{asset('admin/js/titulos.js')}}"></script>
<script src="{{asset('admin/plugins/select2/select2.full.min.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
</script>
@endsection