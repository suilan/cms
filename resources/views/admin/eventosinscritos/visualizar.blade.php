@extends('admin.template.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$inscrito->nome}} </h3>
                </div>
                <div class="box-body">
                    <dl>
			<div class="row">
                            <div class="col-sm-2">
                                <div class="form-gorup">
                                    <dt>CPF</dt>
                                    <dd>{{$inscrito->cpf}}</dd>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-gorup">
                                    <dt>RG:</dt>
                                    <dd>{{$inscrito->rg}}</dd>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-gorup">
                                    <dt>E-mail</dt>
                                    <dd>{{$inscrito->email}}</dd>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-gorup">
                                    <dt>Endereço</dt>
                                    <dd>{{$inscrito->endereco}} - {{$inscrito->cidade}}</dd>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-gorup">
                                    <dt>Telefone</dt>
                                    <dd>{{$inscrito->telefone}}</dd>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-gorup">
                                    <dt>Celular</dt>
                                    <dd>{{$inscrito->celular}}</dd>
                                </div>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Evento</h3>
                </div>
                <div class="box-body">
                    <dl>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-gorup">
                                    II Encontro Estadual de Tabeliães de Protesto do Maranhão
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-sm-12">
                                <div class="form-gorup">
                                    <dt>Tipo de inscrição</dt>
                                    <dd>
                                        @if ($inscrito->inscricao == 1)
                                            Notário / Registrador: Gratuito
                                        @elseif ($inscrito->inscricao == 2)
                                            Funcionário de Cartório: Gratuito
                                        @elseif ($inscrito->inscricao == 3)
                                            Profissionais do Direito: Gratuito
                                        @elseif ($inscrito->inscricao == 4)
                                            Estudante: Gratuito
                                        @elseif ($inscrito->inscricao == 6)
                                            Outros: Gratuito
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Status</h3>
                </div>
                <div class="box-body">
                    <dl>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-gorup">
                                    {{--  @if ($inscrito->comprovante_url != null)
                                        Comprovante enviado
                                    @else
                                        Aguardando Comprovante
                                    @endif  --}}
                                    @if ($inscrito->confirmado == 1)
                                        Confirmado
                                    @else
                                        Aguardando Confirmar
                                    @endif
                                </div>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <a href="{{url('admin/eventosinscritos')}}" class="btn">Voltar</a>
                </div>
            </div>
        </div>
    </div>

@endsection
