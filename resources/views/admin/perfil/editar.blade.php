@extends('admin.template.main')
@section('content')
<div class="row">
	<div class="col-xs-12">
	    <div class="box box-primary">
		    <div class="box-header">
		        <h2 class="titulo">{{$registro->nome?$registro->nome:"Novo Perfil"}}</h2>
		    </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

		    @if( Session::get('sucesso') )
		        <div class="alert alert-info">Seus dados foram salvos com sucesso!</div>
		    @endif

		    @if( Request::segment(3)!="create" )
		    <form action="{{url('admin/perfil/'.$registro->id)}}" method="post" class="form-horizontal">
		        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		        <input type="hidden" name="_method" value="put">
		    @else
		    <form action="{{url('admin/perfil')}}" method="post" class="form-horizontal">
		        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    @endif
	            <div class="box-body">
                    <div class="form-group">
                        <label for="tipoContato" class="col-sm-2 control-label">Nome*</label>
                        <div class="col-sm-6">
                            <input type="text" name="nome" id="nome" class="form-control" value="{{$registro->nome}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="col-sm-2 control-label">Descrição*</label>
                        <div class="col-sm-6">
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{$registro->descricao}}">
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >Páginas Liberadas</label>
	                    <div class="col-sm-3">
							@foreach($paginas as $k=>$p)
							@if( $k!=0 && $k%ceil($paginas->count()/3)==0 )
							</div>
							<div class="col-sm-3">
							@endif
							<div class="checkbox">
								<label>
									<input type="checkbox" name="paginas[{{$p->id}}]" value="1" {{$p->selecionado? 'checked':''}}>
									{{$p->nome}}
									@if($p->pai) - <strong>{{$p->pai}}</strong>@endif
								</label>
							</div>
							@endforeach
						</div>
					</div>
					<hr>
                    <div class="form-group" style="display:block;">
						<label class="col-sm-2 control-label" >Status</label>
	                    <div class="col-sm-10">
							<div class="checkbox">
								<label><input name="status" value="1" type="checkbox" {{$registro->status?'checked':''}} >Ativo</label>
							</div>
						</div>
					</div>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer">
	            	<div class="pull-right">
	            		@if($registro->id!=1)
	            	    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
	            	    @endif
	            	</div>
	                <a href="{{url('admin/perfil')}}" class="btn btn-default"><i class="fa fa-times"></i> Voltar </a>
	            </div>
		    </form>
	    </div>
	</div>
</div>
@endsection
