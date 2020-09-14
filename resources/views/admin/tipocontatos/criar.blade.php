@extends('admin.template.main')
@section('content')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
                <h2 class="titulo">{{$tiposContatos->nome}}</h2>
            </div>
            @if (session('erro'))
                <div class="alert alert-danger">
                {{ session('erro') }}
                </div>
            @endif

            <form action="{{url('admin/tipocontatos')}}"  method="post" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				<!-- <input type="hidden" name="_method" value="put"> -->
	            <div class="box-body">
	            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="tipoContato" style="margin-left:-12px" class="col-sm-2 control-label">Tipo Contato *</label>
                        <div class="col-sm-6">
                            <input type="text" name="nome" id="nome" style="margin-left:-8px" class="form-control" value="{{$tiposContatos->nome}}">
                        </div>
                    </div>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer">
	            	<div class="pull-right">
	            	    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
	            	</div>
	                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
	                <a href="{{url('admin/tipocontatos')}}" class="btn">Voltar</a>
	            </div>
            </form>
		</div>
	</div>
</div>
@endsection
