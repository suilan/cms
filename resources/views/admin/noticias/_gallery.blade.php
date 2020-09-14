<style type="">
    #gallery .destaque-buttons .fileupload-button, #gallery .gallery-collection .fileupload-button {position:relative;cursor:pointer;overflow: hidden;}
    #gallery .destaque-buttons .fileupload-button #fileupload_destaque{position:absolute;top:0;right:0;width:38px;height: 33px;opacity:0;}
    #gallery .gallery-collection{list-style:none;}
    #gallery .destaque-buttons{position: absolute;top:30px;right:20px;}
    #gallery .gallery-collection .buttons-container{position:absolute;top:5px;right:5px;}
    #gallery .gallery-collection .gallery-item{position:relative;float:left;margin:0 10px 10px 0;padding:0;}
    #gallery .gallery-collection .gallery-item .close-button{position:absolute;top:5px;right:5px;}
{position:relative;cursor:pointer;}
    #gallery .gallery-collection .fileupload-button #fileupload_gallery{position:absolute;top:0;right:0;width:38px;height: 33px;opacity:0;}
</style>
<div class="tab-pane active" id="gallery">
    @include('admin.template.alerts')
    <div class="form-group">
        <!-- <label for="imagem" class="control-label" style="padding-left:15px;">Galeria de Imagens</label> -->
        <div style="width: 100%;display: inline-block;">
            <div class="col-sm-3" id="destaque-container" style="border-right: 1px solid gray;">
                <label style="font-weight:normal;">Destaque</label>
                <div class="box no-border">
                    <a class="modal-show" href="#" data-toggle="modal" data-target="#modal-display" data-ref="{{asset($registro->imagem)}}">
                        @if(!$registro->imagem)
                        <img src="http://via.placeholder.com/410x220" class="img-responsive" id="destaque-img" title="Imagem de Destaque">
                        @else
                        <img src="{{asset($registro->getOtherImage(410,220 ).'?time='.time())}}" class="img-responsive" id="destaque-img" title="Imagem de Destaque">
                        @endif
                    </a>
                    <div id="item-loading-destaque" class="overlay" style="border-radius:0;display:none;"><i class="fa fa-refresh fa-spin" style="color:#3c8dbc;"></i></div>
                </div>
                <div class="destaque-buttons">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-url" title="Clique aqui para adicionar o link da imagem"><i class="fa fa-link"></i></button>
                    <button type="button" class="btn btn-default fileupload-button">
                        <i class="fa fa-upload"></i>
                        <input type="file" name="files" id="fileupload_destaque" >
                    </button>
                    <button type="button" class="btn btn-danger delete-button {{!$registro->imagem?'disabled':''}}" value="0"><i class="fa fa-close"></i></button>
                </div>
            </div>

            <ul class="col-sm-9 gallery-collection">
                <label style="display: block;font-weight:normal;">Galeria</label>
                <li class="gallery-item col-sm-2">
                    <div class="box no-border">
                        <img src="http://via.placeholder.com/250x150" class="img-responsive" title="Clique no icone azul e faça o upload da imagem">
                        <div class="buttons-container">
                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-video"><i class="fa fa-youtube-play"></i></button>
                            <span class="btn btn-primary fileupload-button" >
                                <i class="fa fa-upload"></i>
                                <input type="file" name="files" multiple id="fileupload_gallery">
                            </span>
                        </div>
                        <div id="item-loading" class="overlay" style="border-radius:0;display:none;"><i class="fa fa-refresh fa-spin" style="color:#3c8dbc;"></i></div>
                    </div>
                </li>
                @foreach($imagens as $img)
                <li class="gallery-item col-sm-2"> 
                    <a href="#" class="modal-show" data-toggle="modal" data-target="#modal-display" data-ref="{{$img->path}}"> 
                    @if($img->tipo_arquivo==1)
                        @if($img->path)
                        <img src="{{asset($img->getOtherImage(250,150))}}" class="img-responsive" title="Destaque">
                        @else
                        <img src="http://via.placeholder.com/250x150" class="img-responsive" title="Destaque">
                        @endif
                    @else
                        <img src="https://img.youtube.com/vi/{{$img->path}}/2.jpg" class="img-responsive" title="Destaque">
                    @endif
                    </a>
                    <div class="buttons-container">
                        <button type="button" class="btn delete-button btn-danger" value="{{$img->id}}" ><i class="fa fa-close"></i></button>
                    </div>
                </li>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Image -->
<div class="modal modal-danger fade" id="modal-delete" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Deseja realmente excluir este arquivo?</h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn delete-cancel btn-outline pull-left" data-dismiss="modal">Não</button>
        <button type="button" class="btn delete-ok btn-outline">Excluir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Modal add url -->
<div class="modal fade" id="modal-url" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Adicionar URL da Imagem</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" placeholder="Copie a URL">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="url-save"><i class="fa fa-refresh fa-spin" id="url-loading" style="display:none;"></i> Salvar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal add video -->
<div class="modal fade" id="modal-video" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Adicionar Link do Video</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="url">Link</label>
                    <input type="text" class="form-control" id="youtube_input" placeholder="Copie o link">
                </div>
                <div class="form-group">
                    <iframe width="100%" height="322" src="https://www.youtube.com/embed/" frameborder="0" id="youtube-frame" allow="encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="youtube-save"><i class="fa fa-refresh fa-spin" id="youtube-loading" style="display:none;"></i> Salvar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Modal Display -->
<div class="modal fade" id="modal-display" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <!-- <h4 class="modal-title">Adicionar Link do Video</h4> -->
            </div>
            <div class="modal-body">
                <img style="display:none;" width="100%" id="display-img">
                <iframe width="100%" style="display:none;" height="322" src="https://www.youtube.com/embed/" frameborder="0" id="display-video" allow="encrypted-media" allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
