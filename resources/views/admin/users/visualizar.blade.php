@extends('admin.template.main')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
				<h3 class="box-title">{{$usuario->name}} - CPF: {{$usuario->cpf}} | Termo aceite em: {{ $usuario->adesao_at != null ? date('d/m/Y H:i:s', strtotime($usuario->adesao_at)) : null}}</h3>
				</div>
				<div class="box-body">
					<dl>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-gorup">
									<dt>E-mail</dt>
									<dd>{{$usuario->email}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-12">
						        <div class="form-gorup">
									<dt>Endereço</dt>
									<dd>{{$usuario->endereco}} N° {{$usuario->numero}}, {{$usuario->bairro}}
								 	- {{$usuario->cep}} - {{$usuario->cidade}}/{{$usuario->uf}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-gorup">
									<?php  if ($usuario->complemento){?>
										<dt>Complemento</dt>
										<dd>{{$usuario->complemento}}</dd>
									<?php }?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-gorup">
									<dt>Telefone</dt>
									<dd>{{$usuario->telefone}}</dd>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-gorup">
									<dt>Celular 1</dt>
									<dd>{{$usuario->celular1}}</dd>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-gorup">
									<dt>Celular 2</dt>
									<dd>{{$usuario->celular2}}</dd>
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
					<h3 class="box-title">Permissões: {{ucwords($usuario->perfil)}}</h3>
				</div>
				<div class="box-body">
					<dl>
						<div class="row">
						    <div class="col-sm-12">
						        <div class="form-gorup">
						        	@foreach( $permissoes as $p)
									<dt>- {{$p->nome}}{{$p->pai?'('.$p->pai.')':''}}</dt>
									@endforeach
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
				    <a href="{{url('admin/usuarios')}}" class="btn">Voltar</a>
				</div>
			</div>
		</div>
	</div>

@endsection
