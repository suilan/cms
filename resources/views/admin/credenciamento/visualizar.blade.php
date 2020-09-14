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
                    <h3 class="box-title">Status</h3>
                </div>
                <div class="box-body">
                    <dl>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-gorup">
                                  @if ($inscrito->credenciado == 1)
                                      <p style="color: blue">Credenciado</p>
                                  @elseif ($inscrito->confirmado == 1)
                                      <p style="color: blue">Inscrição Confirmada</p>
                                  @elseif ($inscrito->comprovante_url != null && $inscrito->inscricao != 4)
                                      <p style="color: green">Comprovante de Pagamento enviado</p>
                                  @elseif($inscrito->comprovante_url != null && $inscrito->inscricao == 4 && $inscrito->comprovante_estudante == null)
                                      <p style="color: red">Aguardando Comprovante de Estudante</p>
                                  @elseif($inscrito->comprovante_url == null && $inscrito->inscricao == 4 && $inscrito->comprovante_estudante != null)
                                      <p style="color: red">Aguardando Comprovante de Pagamento</p>
                                  @elseif($inscrito->comprovante_url != null && $inscrito->inscricao == 4 && $inscrito->comprovante_estudante != null)
                                      <p style="color: green">Todos os Comprovantes enviados</p>
                                  @elseif($inscrito->comprovante_url == null && $inscrito->inscricao == 4 && $inscrito->comprovante_estudante == null)
                                      <p style="color: red">Aguardando Comprovantes</p>
                                  @elseif($inscrito->comprovante_url == null && $inscrito->inscricao != 4 )
                                      <p style="color: red">Aguardando Comprovante de Pagamento</p>
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
                  @if($inscrito->credenciado != 1)
                      <form action="{{url('admin/credenciamento/'.$inscrito->cpf)}}" id="form_credenciamento" method="post" style="float: right;">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="_method" value="put">
                         <input type="hidden" name="tipoCredenciamento" value="1">
                         <div class="pull-right">
                             <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Credenciar Entrada</button>
                         </div>
                      </form>
                 @endif
                 @if($inscrito->credenciamento_saida != 1 && $inscrito->credenciado == 1)
                      <form action="{{url('admin/credenciamento/'.$inscrito->cpf)}}" id="form_credenciamento" method="post" style="float: right;">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="_method" value="put">
                         <input type="hidden" name="tipoCredenciamento" value="2">
                         <div class="pull-right">
                             <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Credenciar Saída</button>
                         </div>
                      </form>
                 @endif
                    <a href="{{url('admin/credenciamento')}}" class="btn">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
