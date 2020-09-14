@extends('admin.template.main')
@section('content')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
                <h2 class="titulo">{{$registro->nome}}</h2>
            </div>
            @include('admin.template.alerts')

            <form id="usuario_form" action="{{url('admin/credenciamentoboleto'.($registro->id?'/'.$registro->id:''))}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

		    	@if( Request::segment(3)!="create" )
                    <input type="hidden" name="_method" value="put">
                @endif

	            <div class="box-body">
	            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                    	<div class="col-xs-5">
                    	  	<div class="form-group">
                    	  		<label for="input" class="col-sm-5 control-label">Nome do Usuário *</label>
                   				<input style="margin-left:14px;" required type="text" name="name" id="name" class="form-control" value="{{old('name')?old('name'):$registro->name}}"  title="Cartório">
                    	  	</div>
                    	</div>
                    	<div class="col-xs-3">
                    	  	<div class="form-group">
                    	  		<label for="input" class="col-sm-1 control-label">CPF</label>
                   				<input style="margin-left:14px;" required type="text" name="cpf" id="cpf" class="form-control cpf-mask" value="{{old('cpf')?old('cpf'):$registro->cpf}}" title="CNPJ">
                    	  	</div>
                    	</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="input" class="col-sm-9 control-label">Data de Nascimento </label>
								<input style="margin-left:14px;" required type="text" name="dtNasc" id="dtNasc" class="dtNasc form-control" data-grupo="usuario" value="{{  old('dtNasc')?old('dtNasc'):$registro->data_nascimento}}" title="dtNasc">
							</div>
						</div>
					</div>
                    <div class="row">
		            	<div class="col-sm-3">
		            	    <div class="form-group">
			            		<label for="input" class="col-sm-1 control-label">CEP </label>
								<input style="margin-left:14px;" required type="text" name="cep" id="cep" class="cep form-control" data-grupo="usuario" value="{{  old('cep')?old('cep'):$registro->cep}}" title="CEP">
							</div>
		            	</div>
		            	<div class="col-xs-5">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-1 control-label">Cidade </label>
								<input readonly="true" style="margin-left:14px;" type="text" name="cidadeUsuario" id="cidadeUsuario" class="cidade usuario form-control" value="{{old('cidadeUsuario')?old('cidadeUsuario'):$registro->cidade}}"   title="Cidade">
								<input type="hidden" name="cidadeUsuarioIBGE" id="cidadeUsuarioIBGE" class="form-control usuario ibge" value="{{old('cidadeUsuarioIBGE')?old('cidadeUsuarioIBGE'):$registro->ibge}}" title="Cidade">
						  	</div>
						</div>
		            </div>
		            <div class="row">
						<div class="col-xs-4">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Endereço </label>
								<input style="margin-left:14px;" required type="text" name="usuarioEndereco" id="usuarioEndereco" class="endereco usuario form-control" value="{{old('usuarioEndereco')?old('usuarioEndereco'):$registro->endereco}}" title="Endereço">
						  	</div>
						</div>
						<div class="col-xs-3">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Bairro </label>
								<input style="margin-left:14px;" required type="text" name="usuarioBairro" id="usuarioBairro" class="bairro usuario form-control" value="{{old('usuarioBairro')?old('usuarioBairro'):$registro->bairro}}" title="Bairro">
						  	</div>
						</div>
						<div class="col-xs-1">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-1 control-label">Nº </label>
								<input style="margin-left:14px;" required type="text" name="usuarioNumero" id="usuarioNumero" class="form-control" value="{{old('usuarioNumero')?old('usuarioNumero'):$registro->numero}}"  title="Número">
						  	</div>
						</div>
					</div>
		            <div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Complemento </label>
								<input style="margin-left:14px;" type="text" name="usuarioComplemento" id="usuarioComplemento" class="form-control" value="{{old('usuarioComplemento')?old('usuarioComplemento'):$registro->complemento}}" title="Complemento">
						  	</div>
						</div>
		            </div>
		            <div class="row">
						<div class="col-xs-2">
						  	<div class="form-group">
						  		<label for="telefone" class="col-sm-2 control-label">Telefone</label>
								<input style="margin-left:14px;" type="text" name="telefone" id="telefone" class="form-control" value="{{old('telefone')?old('telefone'):$registro->telefone}}" title="Telefone">
						  	</div>
						</div>
						<div class="col-xs-3">
						  	<div class="form-group">
						  		<label for="celular1" class="col-sm-5">Celular 1*</label>
								<input style="margin-left:14px;" required type="text" name="celular1" id="celular1" class="form-control" value="{{old('celular1')?old('celular1'):$registro->celular1}}"   title="Celular 1">
						  	</div>
						</div>
						<div class="col-xs-3">
						  	<div class="form-group">
						  		<label for="celular2" class="col-sm-5 control-label">Celular 2 </label>
								<input style="margin-left:14px;"  type="text" name="celular2" id="celular2" class="form-control" value="{{old('celular2')?old('celular2'):$registro->celular2}}" title="Celular 2">
						  	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">E-mail*</label>
								<input style="margin-left:14px;" required type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$registro->email}}" title="Complemento">
						  	</div>
						</div>
					</div>
					@if ($registro->creden != 2)
						<div class="row">
							<div class="col-xs-8">
								<div class="form-group">
									<label for="input" class="col-sm-6 control-label">Documento de Identificação</label>
									<input style="margin-left:14px;" type="file" name="doccreden1" id="doccreden1" class="form-control" title="Documento de credenciamento">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8">
								<div class="form-group">
									<label for="input" class="col-sm-6 control-label">Selfie com Documento de Identificação</label>
									<input style="margin-left:14px;" type="file" name="doccreden2" id="doccreden2" class="form-control" title="Documento de credenciamento">
								</div>
							</div>
						</div>						
					@endif
		            <div class="row">
		            	<div class="col-sm-4">
		            	    <div class="form-group">
			            		<label for="input" class="col-sm-1 control-label">Senha </label>
								<input style="margin-left:14px;" type="password" name="senha" id="senha" class="form-control" value="" title="Senha">
							</div>
		            	</div>
		            	<div class="col-sm-4">
		            	    <div class="form-group">
			            		<label for="input" class="col-sm-9 control-label">Confirmação de Senha </label>
								<input  style="margin-left:14px;" type="password" name="confirmaSenha" id="confirmaSenha" class="form-control" value="" title="CEP">
							</div>
		            	</div>
		            </div>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer">
	            	<div class="pull-right">
	            	    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
	            	</div>
	                <a href="{{url('admin/credenciamentoboleto')}}" class="btn">Voltar</a>
	            </div>
            </form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('admin/js/validacoes.js')}}"></script>
<script src="{{asset('admin/js/usuario-validacao.js')}}"></script>

@endsection