@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="{{url('admin/noticias/'.($registro->id?$registro->id.'/edit':'create'))}}" >Foumulário</a></li>
              @if(request()->segment(3)=='create')
              <li class="disabled" title="A galeria só será disponibilizada depois que a noticia for salva"><a href="#" >Galeria</a></li>
              @else
              <li class="" title=""><a href="{{url('admin/noticias/'.$registro->id.'/galeria')}}">Galeria</a></li>
              @endif
              <li><h2 class="titulo" style="margin:10px;font-size:20px;font-weight:bold;">{{$registro->titulo?$registro->titulo:"Nova Notícia"}}</h2></li>
            </ul>
            <div class="tab-content">
                @if(request()->segment(3)=='create')
                <div class="callout callout-warning fixed">
                    <h4>A aba "Galeria" só estará disponível para adicionar imagens depois que a notícia for salva no sistema.</h4>
                </div>
                @endif
                <div class="tab-pane active" id="form">
                    @include('admin.template.alerts')

                    <!-- /.box-header -->
                    <form action="{{url('admin/noticias'.($registro->id?'/'.$registro->id:''))}}" id="form_noticia" method="post">
                        <div class="box-body" style="padding-left: 20px;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @if( Request::segment(3)!="create" )
                            <input type="hidden" name="_method" value="put">
                            @endif

                            <div class="form-group">
                                <label for="noticia" class="control-label" title="Título Obrigatório">Título da Notícias*</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{$registro->titulo}}">
                            </div>

                            <br/>
                            <!-- corpo da notícia -->
                            <div class="form-group">
                                <textarea id="editor" placeholder="Digite uma nova notícia" name="conteudo" class="form-control" style="height: 300px;">{{$registro->conteudo}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-12 control-label">Status</label>
                                <div class="radio" style="padding: 0 0 0 15px;">
                                    <label>
                                        <input name="tipostatus" id="tipostatus1" value="0" {{$registro->status?'':'checked=""'}} type="radio">
                                        <span class="label label-danger">Não Publicado</span>
                                    </label>
                                </div>
                                <div class="radio" style="padding: 0 0 0 15px;">
                                    <label>
                                        <input name="tipostatus" id="tipostatus2" value="1" {{$registro->status?'checked=""':''}} type="radio">
                                        <span class="label label-success">Publicado</span>
                                    </label>
                                </div>
                            </div>
                            <br/>
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
            </div>
        </div>

    <!-- /. box -->
    </div>
</div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script> -->
<script src="{{asset('admin/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    if( document.getElementById('editor') )
    {
      CKEDITOR.replace('editor');
    }
  });
</script>
@endsection