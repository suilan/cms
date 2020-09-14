@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="titulo">{{$registro->titulo}}</h2>
            </div>
            @if ( $errors->count() > 0)
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
            <form action="{{url('admin/remessas'.($registro->id?'/'.$registro->id:''))}}" id="form_registro" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if( Request::segment(3)!="create" )
                    <input type="hidden" name="_method" value="put">
                    @endif

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="control-label">Olá!</label>
                                <p style="text-align: justify;">Para fazer o upload do arquivo no formato <strong>.xls(Excel)</strong>, os dados apresentados no arquivo precisam estar na ordem apresentada no <a href="{{asset('arquivos/exemplo.xls')}}">exemplo.xls</a>, aba <strong>Dados</strong></p>
                                <p style="text-align: justify;">Os <strong>IDs</strong> da coluna <strong>Cidade</strong>, <strong>Espécie</strong> e <strong>Endosso</strong> podem ser encontrados na planilha exemplo.xls, nas abas com seus respectivos nomes.</p>
                                <p style="text-align: justify;">Se por alguma razão os dados não estivem no formato desejado ou na ordem do arquivo exemplo.xls, não será possível realizar a leitura correta.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cartorio" class="control-label">Cartório</label>
                                @if( $isAdmin )
                                    <select name="cartorio" id="cartorio" class="form-control">
                                        <option value="">-- Cartório --</option>
                                        @foreach($cartorios as $c)
                                            <option value="{{$c->id}}" {{$c->id==$registro->cartorio_id?'selected':''}} >{{$c->nome}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" >
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Upload do Arquivo
                                    <input type="hidden" name="imgarq" value="{{$registro->imagem?'true':'false'}}">
                                    <input type="file" id="arquivoRemessa" name="arquivoRemessa">
                                </div>
                                @if( $registro->arquivo )
                                {{$registro->arquivo.' - '.$registro->updated_at}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                    </div>
			<button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Descartar</button>
                </div>
            </form>
        <!-- /.box-footer -->
        </div>
    <!-- /. box -->
    </div>
</div>

<script type="text/javascript">
    $('.alert-info').delay(5000).fadeOut('slow');
</script>
@endsection
