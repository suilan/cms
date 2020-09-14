@extends('admin.template.main')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="titulo">{{$categoriadownload->descricao?$categoriadownload->descricao:"Nova Categoria de Download"}}</h2>
                </div>
                @if (session('erro'))
                    <div class="alert alert-danger">
                        {{ session('erro') }}
                    </div>
                @endif

                @if( Session::get('sucesso') )
                    <div class="alert alert-info">Seus dados foram salvos com sucesso!</div>
                @endif

                <form action="{{url('admin/categoriadownloads/'.$categoriadownload->id)}}"  method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="tipoContato" class="col-sm-2 control-label">Categoria de Download*</label>
                            <div class="col-sm-6">
                                <input type="text" name="descricao" id="descricao" class="form-control" value="{{$categoriadownload->descricao}}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Salvar</button>
                        </div>
                        <a href="{{url('admin/categoriadownloads')}}" class="btn btn-default"><i class="fa fa-times"></i> Voltar </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@endsection
