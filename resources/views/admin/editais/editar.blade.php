@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
		            <a class="photo" class="pull-left" href="#">
                @if( !empty($noticia->imagem))
                    <img src="{{asset($noticia->getOtherImage(200,200))}}" height="63" class="pull-left" style="margin:15px 10px;">
                @else
                    <img src="{{$noticia->imagem_url}}" height="63" class="pull-left" style="margin-right:20px;">
                @endif
                </a>
                <h2 class="titulo">{{$noticia->titulo}}</h2>
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
            <form action="{{url('admin/noticias/'.$noticia->id)}}" id="form_noticia" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		            <input type="hidden" name="_method" value="put">

                    <div class="form-group">
                        <label for="noticia" style="margin-left:-12px" class="col-sm-2 control-label">Título da Notícia *</label>
                        <div class="col-sm-12">
                            <input type="text" name="titulo" id="titulo" style="margin-left:-8px" class="form-control" value="{{$noticia->titulo}}">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="status" style="margin-left:-12px" class="col-sm-2 control-label">Status</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipostatus" id="tipostatus1" value="0" {{$noticia->status?'':'checked=""'}} type="radio">
                                <span class="label label-danger">Não Publicado</span>
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipostatus" id="tipostatus2" value="1" {{$noticia->status?'checked=""':''}} type="radio">
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>

		    <!-- IMAGENS -->
                    <div class="form-group">
			<label for="imagem" class="col-sm-2 control-label">Origem da Imagem</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                @if( Input::old('tipoimagem')=='img-url' || $noticia->imagem_url )
                                <input name="tipoimagem" id="tipoimagem1" value="img-url" type="radio" checked="" >
                                @else
                                <input name="tipoimagem" id="tipoimagem1" value="img-url" type="radio" >
                                @endif
                                Copiar URL
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                @if( Input::old('tipoimagem')=='img-file' || $noticia->imagem )
                                <input name="tipoimagem" id="tipoimagem2" value="img-file" type="radio" checked="" >
                                @else
                                <input name="tipoimagem" id="tipoimagem2" value="img-file" type="radio" >
                                @endif
                                Adicionar Arquivo
                            </label>
                        </div>

                    	<div class="form-group img-input img-url">
                        	<div class="btn btn-default btn-file">
                            		<i class="fa fa-paperclip"></i> URL da imagem
                            	<input type="text" id="imagemurl" name="imagemurl" style="width:700px;padding-left:5px;" value="{{$noticia->imagem_url}}">
                        	</div>
                    	</div>

                    <div class="form-group img-input img-file" style="display:none;">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Imagem &nbsp;
                            <input type="hidden" name="imgarq" value="{{$noticia->imagem?'true':'false'}}">
                            <input type="file" id="imagemarquivo" name="imagemarquivo">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                    <!-- corpo da notícia -->
                    <div class="form-group">
                        <textarea id="editor" placeholder="Digite uma nova notícia" name="conteudo" class="form-control" style="height: 300px;">{{$noticia->conteudo}}</textarea>
                    </div>
                </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Salvar</button>
                    </div>
			<button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Descartar</button>
                </div>
            </form>
        <!-- /.box-footer -->
        </div>
    <!-- /. box -->
    </div>
</div>
<script>
    function originImageSelection (argument) {
        var $input = document.getElementsByName("tipoimagem"),
        $imgContainers = document.getElementsByClassName("img-input");

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

<script type="text/javascript">
        $('.alert-info').delay(5000).fadeOut('slow');
    </script>
@endsection
