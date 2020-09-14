@extends('admin.template.main')
@section('content')
<div class="row">
	<div class="col-xs-12">
	    <div class="box box-primary">
		    <div class="box-header with-border">
		        <h2 class="titulo">{{$especies->nome?$especies->codigo.' - '.$especies->nome:"Nova Espécie de Protesto"}}</h2>
		    </div>
		    @if (session('erro'))
		        <div class="alert alert-danger">
		        {{ session('erro') }}
		        </div>
		    @endif

		    @if( Request::segment(3)!="create" )
		    <form method="post" action="{{url('admin/especies/'.$especies->id)}}" >
		    	<input type="hidden" name="_method" value="PUT">
		    @else
		    <form method="post" action="{{url('admin/especies')}}" >
		    @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <div class="box-body">
		            @if( Session::get('sucesso') )
		               <div class="callout callout-info"><i class="fa fa-info-circle"></i> Seus dados foram salvos com sucesso!</div>
		            @endif
                    <div class="form-group">
                        <label for="nome" class="control-label">Especie*</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="{{$especies->nome}}" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo" class="control-label">Código*</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{$especies->codigo}}" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <div class="radio">
                            <label>
                                <input name="status" id="status1" value="0" {{$especies->status?'':'checked=""'}} type="radio">
                                <span class="label label-danger">Não Publicado</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="status" id="status2" value="1" {{$especies->status?'checked=""':''}} type="radio">
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer">
	            	<div class="pull-right">
	            	    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
	            	</div>
	                <!-- <a href="{{url('admin/especies')}}" class="btn btn-default"><i class="fa fa-times"></i> Voltar </a> -->
	            </div>
		    </form>
	    </div>
	</div>
</div>
@endsection
