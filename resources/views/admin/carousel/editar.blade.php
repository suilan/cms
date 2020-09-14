@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<style type="text/css">
    .form-group a.photo {display: block;}
    .form-group a.photo img{width:50%;margin:0 25%;background-color: #3c8dbc;}
    @media screen and (max-width: 1200px) { .form-group a.photo img{width:100%;margin:10px 0;} }
</style>
<div class="row">
    <div class="col-xs-12">
        @include('admin.template.alerts')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="titulo" style="margin:0;">{{$carousel->titulo?$carousel->titulo:'Nova Imagem de Carousel'}}</h3>
            </div>

            <!-- /.box-header -->
            @if(substr_count(Request::url(), 'edit'))
            <form action="{{url('admin/carousel/'.$carousel->id)}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
            @else
            <form action="{{url('admin/carousel')}}"  method="post" enctype="multipart/form-data">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">
                    <div class="form-group">
                        <a class="photo" class="pull-left" href="#" >
                            <img class="pull-left" style=""
                                @if( !empty($carousel->imagem))
                                    src="{{asset($carousel->imagem)}}?time={{time()}}" 
                                @elseif(!empty($carousel->imagem_url))
                                    src="{{$carousel->imagem_url}}" 
                                @else
                                    src="{{asset('admin/img/carousel-3896x1292.png')}}"
                                @endif
                                >
                        </a>
                    </div>
                    <div class="form-group">
                        <label for="titulo" class="control-label">Título da Imagem *</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{$carousel->titulo}}">
                    </div>
                    <div class="form-group">
                        <label for="link" class="control-label">Link*</label>
                        <input type="text" name="link" id="link" class="form-control" value="{{$carousel->link}}">
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <div class="radio">
                            <label>
                                <input name="tipostatus" id="tidownloadsatus1" value="0" {{$carousel->status?'':'checked=""'}} type="radio">
                                <span class="label label-danger">Não Publicado</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="tipostatus" id="tidownloadsatus2" value="1" {{$carousel->status?'checked=""':''}} type="radio">
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>
                                        <div class="form-group">
                        <label for="imagem" class="control-label">Origem da Imagem</label>
                        <br/>
                        <div class="radio">
                            <label>
                                @if( Input::old('tipoimagem')=='img-url' || $carousel->imagem_url )
                                <input name="tipoimagem" id="tipoimagem1" value="img-url" type="radio" checked="" >
                                @else
                                <input name="tipoimagem" id="tipoimagem1" value="img-url" type="radio" >
                                @endif
                                Copiar URL
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                @if( Input::old('tipoimagem')=='img-file' || $carousel->imagem )
                                <input name="tipoimagem" id="tipoimagem2" value="img-file" type="radio" checked="" >
                                @else
                                <input name="tipoimagem" id="tipoimagem2" value="img-file" type="radio" >
                                @endif
                                Adicionar Arquivo
                            </label>
                        </div>
                    </div>
                    <div class="form-group img-input img-url" >
                        <div class="btn btn-default btn-file" >
                            <i class="fa fa-paperclip"></i> URL da imagem
                            <input type="text" id="imagemurl" name="imagemurl" style="width:700px;" value="{{$carousel->imagem_url}}">
                        </div>
                    </div>

                    <div class="form-group img-input img-file">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Imagem do Carousel
                                  <input type="hidden" name="imgarq" value="{{$carousel->imagem?'true':'false'}}">
                            <input type="file" id="imagemarquivo" name="imagemarquivo">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                    </div>
                    <button type="reset" class="btn descartar btn-danger"><i class="fa fa-eraser"></i> Descartar</button>
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
@endsection
