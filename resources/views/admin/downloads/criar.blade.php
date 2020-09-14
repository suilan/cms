@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="titulo">{{Input::old('titulo')}}</h2>
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
            <form action="{{url('admin/downloads')}}" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                <div class="box-body">
                    <!-- Titulo da Notícia -->
                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="noticia" style="margin-left:-12px" class="col-sm-2 control-label">Título do Download *</label>
                        <div class="col-sm-6">
                            <input type="text" name="titulo" id="titulo" style="margin-left:-8px" class="form-control" value="{{Input::old('titulo')}}">
                        </div>
                    </div>
                    <br/>
                    <!-- Titulo da Notícia -->
                    <div class="form-group">
                        <label for="categoriadownload" style="margin-left:-12px" class="col-sm-2 control-label">Categoria *</label>
                        <div class="col-sm-6" style="margin-left: -9px;">
                            <select name="categoriadownload" id="categoriadownload" class="form-control" required="required">
                                <option value="">-- Selecione uma categoria --</option>
                                @foreach($categoriadownload as $r)
                                    <option value="{{$r->id}}">{{$r->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br/>
                    <!-- Status da Notícia -->
                    <div class="form-group">
                        <label for="" style="margin-left:-12px" class="col-sm-2 control-label">Status</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipostatus" id="tipostatus1" value="0" {{Input::old('status')?'':'checked=""'}} type="radio">
                                <span class="label label-danger">Não Publicado</span>
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipostatus" id="tipostatus2" value="1" type="radio" {{Input::old('status')?'':'checked=""'}}>
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>
                    <br/>
                    <!-- origem da imagem a ser usada na notícia -->
                    <div class="form-group">
                        <label for="imagem" style="margin-left:-12px" class="col-sm-2 control-label">Origem do Arquivo</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipoarquivo" id="tipoarquivo1" value="arq-url" checked="" type="radio" {{(!Input::old('tipoarquivo') || Input::old('tipoarquivo')=='arq-url')?'checked=""':''}}>
                                Copiar URL
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipoarquivo" id="tipoarquivo2" value="arq-file" type="radio" {{Input::old('tipoarquivo')=='arq-file'?'checked=""':''}}>
                                Adicionar Arquivo
                            </label>
                        </div>
                    </div>
                    <div class="form-group arq-input arq-url">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> URL do Arquivo
                            <input type="text" id="arquivourl" name="arquivourl" style="width:700px;padding-left:5px;" value="{{Input::old('arquivourl')}}">
                        </div>
                    </div>
                    <div class="form-group arq-input arq-file" style="display:none;">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Arquivo para Download &nbsp;
                            <input type="file" id="arquivofile" name="arquivofile">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                    <!-- corpo da notícia -->
                    <div class="form-group">
                        <textarea id="editor" placeholder="Digite um conteúdo para o Link do Download" name="conteudo" class="form-control" style="height: 300px;">{{Input::old('conteudo')}}</textarea>
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
<script>
    function originImageSelection (argument) {
        var $input = document.getElementsByName("tipoarquivo"),
        $imgContainers = document.getElementsByClassName("arq-input");

        // Function to execute on change event
        function onchange (event) {
            var $target = event.target;

            if( $target.checked )
            {
                for (var i = 0; i < $imgContainers.length; i++) {
                    if( $imgContainers[i].className.indexOf($target.value)>=0 ){
                        $imgContainers[i].style.display = "block";
                    }
                    else{
                        $imgContainers[i].style.display = "none";
                    }
                };
            }
        }

        // Apply the event in every radio input
        for (var i = 0; i < $input.length; i++){
            if( "addEventListener" in $input[i] ){
                $input[i].addEventListener("change", onchange);
            }
            else{
                $input[i].attachEvent("onchange", onchange);
            }
        };
    }
    originImageSelection();
</script>
@endsection
