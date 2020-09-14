@extends('admin.template.main')
@section('content')

<style>
	input {
		text-transform: uppercase;
	}
</style>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
                <h2 class="titulo">{{$registro->nome}}</h2>
            </div>
            @include('admin.template.alerts')

            <form id="usuario_form" action="{{url('admin/representante')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

		    	@if( Request::segment(3)!="create" )
                	<input type="hidden" name="_method" value="put">
                @endif

	            <div class="box-body">
	            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                    	<div class="col-xs-5">
                    	  	<div class="form-group">
                    	  		<label for="input" class="col-sm-5 control-label">Razão Social *</label>
                   				<input style="margin-left:14px;" required type="text" name="razao" id="razao" class="form-control" value="{{old('razao')?old('razao'):$registro->razao}}"  title="Cartório">
                    	  	</div>
                    	</div>
                    	<div class="col-xs-3">
                    	  	<div class="form-group">
                    	  		<label for="input" class="col-sm-7 control-label">CNPJ da Matriz *</label>
                   				<input style="margin-left:14px;" required type="text" name="cnpj" id="cnpj" class="form-control cnpj" value="{{old('cnpj')?old('cnpj'):$registro->cnpj}}" title="CNPJ">
                    	  	</div>
                    	</div>
                    </div>
                    <div class="row">
		            	<div class="col-sm-3">
		            	    <div class="form-group">
			            		<label for="input" class="col-sm-1 control-label">CEP </label>
								<input style="margin-left:14px;" required type="text" name="cep" id="cep" class="cep form-control" data-grupo="usuario" value="{{old('cep')?old('cep'):$registro->cep}}" title="CEP">
							</div>
		            	</div>
		            	<div class="col-xs-5">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-1 control-label">Cidade </label>
								<input readonly="true" style="margin-left:14px;" type="text" name="cidadeUsuario" id="cidadeUsuario" class="cidade usuario form-control" value="{{old('cidade_id')?old('cidade_id'):$registro->cidade_id}}"   title="Cidade">
								<input type="hidden" name="cidade" id="cidade" class="form-control usuario ibge" value="{{old('cidadeUsuarioIBGE')?old('cidadeUsuarioIBGE'):$registro->ibge}}" title="Cidade">
						  	</div>
						</div>
		            </div>
		            <div class="row">
						<div class="col-xs-4">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Endereço </label>
								<input style="margin-left:14px;" type="text" name="endereco" id="endereco" class="endereco usuario form-control" value="{{old('endereco')?old('endereco'):$registro->endereco}}" title="Endereço">
						  	</div>
						</div>
						<div class="col-xs-3">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Bairro </label>
								<input style="margin-left:14px;" type="text" name="bairro" id="bairro" class="bairro usuario form-control" value="{{old('bairro')?old('bairro'):$registro->bairro}}" title="Bairro">
						  	</div>
						</div>
						<div class="col-xs-1">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-1 control-label">Nº </label>
								<input style="margin-left:14px;" type="text" name="numero" id="numero" class="form-control" value="{{old('numero')?old('numero'):$registro->numero}}"  title="Número">
						  	</div>
						</div>
					</div>
		            <div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="input" class="col-sm-2 control-label">Complemento </label>
								<input style="margin-left:14px;" type="text" name="complemento" id="complemento" class="form-control" value="{{old('complemento')?old('complemento'):$registro->complemento}}" title="Complemento">
						  	</div>
						</div>
		            </div>
		            <div class="row">
						<div class="col-xs-2">
						  	<div class="form-group">
						  		<label for="telefone" class="col-sm-2 control-label">Telefone</label>
								<input style="margin-left:14px;" required type="text" name="telefone" id="telefone" class="form-control" value="{{old('telefone')?old('telefone'):$registro->telefone}}" title="Telefone">
						  	</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="input" class="col-sm-2 control-label">E-mail*</label>
							  	<input style="margin-left:14px;" required type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$registro->email}}" title="Complemento">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 30px; margin-bottom: 20px">
						<div class="col-xs-10">
						  	<div class="form-group">
								<label for="input" class="col-sm-10 control-label" style="color: red">Para que o credenciamento seja efetivado, precisamos que os seguintes documentos sejam anexados a este cadastro.</label>
						  	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="contratosocial" class="col-sm-5 control-label">Contrato Social*</label>
								<input style="margin-left:14px;" required type="file" name="contratosocial" id="contratosocial" class="form-control" value="{{old('contratosocial')?old('contratosocial'):$registro->contratosocial}}" title="contratosocial">
						  	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="cartaocnpj" class="col-sm-5 control-label">Cartão CNPJ*</label>
								<input style="margin-left:14px;" required type="file" name="cartaocnpj" id="cartaocnpj" class="form-control" value="{{old('cartaocnpj')?old('cartaocnpj'):$registro->cartaocnpj}}" title="cartaocnpj">
						  	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-8">
						  	<div class="form-group">
						  		<label for="procuracao" class="col-sm-5 control-label">Procuração</label>
								<input style="margin-left:14px;" type="file" name="procuracao" id="procuracao" class="form-control" value="{{old('procuracao')?old('procuracao'):$registro->procuracao}}" title="procuracao">
						  	</div>
						</div>
					</div>
				</div>
	            <!-- /.box-body -->
	            <div class="box-footer">
	            	<div class="pull-right">
	            	    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
	            	</div>
	                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
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