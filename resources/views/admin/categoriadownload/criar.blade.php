@extends('admin.template.main')
@section('content')
    <!-- Your Page Content Here -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="titulo">{{Input::old('descricao')}}</h2>
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
            <!-- /.box-header -->
                <form action="{{url('admin/categoriadownloads')}}" method="post">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                    <div class="box-body">
                        <!-- Titulo da Notícia -->
                        <div class="form-group">
                            <label for="noticia" style="margin-left:-12px" class="col-sm-2 control-label">Título da Categoria de Download *</label>
                            <div class="col-sm-6">
                                <input type="text" name="descricao" id="descricao" style="margin-left:-8px" class="form-control" value="{{Input::old('descricao')}}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Salvar</button>
                        </div>
                        <button type="reset" class="btn btn-danger descartar"><i class="fa fa-times"></i> Voltar</button>
                    </div>
                </form>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
    </div>
@stop
@endsection
