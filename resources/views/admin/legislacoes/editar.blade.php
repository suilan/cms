@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="titulo">{{$legislacoes->descricao}}</h2>
                <a class="photo" class="pull-left" href="#">
        		@if( !empty($legislacoes->arquivo))
                    <h3><a href="{{asset($legislacoes->arquivo)}}" height="63" target="_blank" class="pull-left" style="margin-right:20px;" >Download da Legislação</a></h3>
                @elseif ( !empty($legislacoes->arquivo_url))
                    <h3><a href="{{asset($legislacoes->arquivo_url)}}" height="63" target="_blank" class="pull-left" style="margin-right:20px;" >Visualizar Legislação</a></h3>
                @else
                    
        		@endif
                </a>
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
            <form action="{{url('admin/legislacoes'.($legislacoes->id?'/'.$legislacoes->id:''))}}"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if( Request::segment(3)!="create" )
                        <input type="hidden" name="_method" value="put">
                    @endif
                <div class="box-body">
                    <div class="form-group" style="margin-bottom: 45px;">
                        <label for="noticia" style="margin-left:-12px" class="col-sm-2 control-label">Título da Legislação *</label>
                        <div class="col-sm-6">
                            <input type="text" name="descricao" id="descricao" style="margin-left:-8px" class="form-control" value="{{$legislacoes->descricao}}">
                        </div>
                    </div>
                    <!-- Titulo da Notícia -->
                    <div class="form-group" style="margin-bottom: 90px;">
                        <label for="tipoLegislacoes" style="margin-left:-12px" class="col-sm-2 control-label">Categoria *</label>
                        <div class="col-sm-6" style="margin-left: -9px;">
                            <select name="tipoLegislacoes" id="tipoLegislacoes" class="form-control" required="required">
                                <option value="">-- Selecione uma categoria --</option>
                                @foreach($tipoLegislacoes as $r)
                                    <option value="{{$r->id}}" {{$legislacoes->tipo_legislacao_id==$r->id?"selected":""}}>{{$r->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" style="margin-left:-12px" class="col-sm-2 control-label">Status</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 4px;">
                            <label>

                                <input name="tipostatus" id="tiposatus1" value="0" {{$legislacoes->status?'':'checked=""'}} type="radio">
                                <span class="label label-danger">Não Publicado</span>
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 4px;">
                            <label>
                                <input name="tipostatus" id="tiposatus2" value="1" {{$legislacoes->status?'checked=""':''}} type="radio">
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imagem" class="col-sm-2 control-label" style="padding-left: 3px;">Origem da Legislação</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 4px;">
                            <label>
                                @if( Input::old('tipoarquivo')=='arq-url' || $legislacoes->arquivo_url )
                                <input name="tipoarquivo" id="tipoarquivo1" value="arq-url" type="radio" checked="" >
                                @else
                                <input name="tipoarquivo" id="tipoarquivo1" value="arq-url" type="radio" >
                                @endif
                                Copiar URL
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 4px;">
                            <label>
                                @if( Input::old('tipoarquivo')=='arq-file' || $legislacoes->arquivo )
                                <input name="tipoarquivo" id="tipoarquivo2" value="arq-file" type="radio" checked="" >
                                @else
                                <input name="tipoarquivo" id="tipoarquivo2" value="arq-file" type="radio" >
                                @endif
                                Adicionar Arquivo
                            </label>
                        </div>
		    </div>	
                    <div class="form-group arq-input arq-url">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> URL da Legislação
                            <input type="text" id="arquivourl" name="arquivourl" style="width:700px;padding-left:5px;" value="{{$legislacoes->arquivo_url}}">
                        </div>
                    </div>

                    <div class="form-group arq-input arq-file" >
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Legislação
                            <input type="hidden" name="arqfile" value="{{$legislacoes->arquivo?'true':'false'}}">
                            <input type="file" id="arquivofile" name="arquivofile">
                        </div>
                    </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Salvar Alterações</button>
                    </div>
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

        for (var i = 0; i < $imgContainers.length; i++) {
            if( $input[i].checked ){
                $imgContainers[i].style.display = "block";
            }
            else{
                $imgContainers[i].style.display = "none";
            }
        };
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
