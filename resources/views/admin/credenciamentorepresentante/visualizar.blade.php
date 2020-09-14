@extends('admin.template.main')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"><strong>{{ strtoupper($empresa->razao) }}</strong> - CNPJ: {{ $empresa->cnpj }}</h3>
					<br />
				<h3 class="box-title">Representante: <strong>{{ strtoupper($usuario->name) }}</strong> - CPF: {{ $usuario->cpf }} | Contato: {{ $usuario->celular1 }}</h3>
				</div>
				<div class="box-body">
					<dl>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-group">
									<dt>E-mail</dt>
									<dd>{{$empresa->email}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-12">
						        <div class="form-group">
									<dt>Endereço</dt>
									<dd>{{$empresa->endereco}} N° {{$empresa->numero}}, {{$empresa->bairro}}
								 	- {{$empresa->cep}} - {{$empresa->cidade}}/{{$empresa->uf}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-group">
									<?php  if ($empresa->complemento){?>
										<dt>Complemento</dt>
										<dd>{{$empresa->complemento}}</dd>
									<?php }?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									<dt>Telefone</dt>
									<dd>{{$empresa->telefone}}</dd>
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
									<dt>Imagem do Contrato Social</dt>
									@if($empresa->cartaocnpj)
										@if(strpos($empresa->contratosocial,".pdf"))
											<a target="_blank" href="{{ asset($empresa->contratosocial) }}">Visualizar Arquivo</a>
										@else
											<a target="_blank" href="{{ asset($empresa->contratosocial) }}">
												<img style="width: 300px" src="{{ asset($empresa->contratosocial) }}" alt="Imagem para credenciamento"/>
											</a>
										@endif
									@else
										Documento não informado	
									@endif
                                </div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<dt>Imagem do Cartão CNPJ</dt>
									@if($empresa->cartaocnpj)
										@if(strpos($empresa->cartaocnpj,".pdf"))
											<a target="_blank" href="{{ asset($empresa->cartaocnpj) }}">Visualizar Arquivo</a>
										@else
											<a target="_blank" href="{{ asset($empresa->cartaocnpj) }}">
												<img style="width: 300px" src="{{ asset($empresa->cartaocnpj) }}" alt="Imagem para credenciamento"/>
											</a>
										@endif
									@else
										Documento não informado
									@endif
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<dt>Imagem da Procuração</dt>
									@if($empresa->procuracao)
										@if(strpos($empresa->procuracao,".pdf"))
											<a target="_blank" href="{{ asset($empresa->procuracao) }}">Visualizar Arquivo</a>
										@else
											<a target="_blank" href="{{ asset($empresa->procuracao) }}">
												<img style="width: 300px" src="{{ asset($empresa->procuracao) }}" alt="Imagem para credenciamento"/>
											</a>
										@endif
									@else
									    Documento não informado
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
				    <a href="{{url('admin/credenciamentorepresentante')}}" class="btn">Voltar</a>
				</div>
			</div>
		</div>
	</div>
@endsection
