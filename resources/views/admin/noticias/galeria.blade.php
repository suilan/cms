@extends('admin.template.main')

@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="{{url('admin/noticias/'.$registro->id.'/edit')}}" >Foumulário</a></li>
              <li class="active" title=""><a href="{{url('admin/noticias/'.$registro->id.'/galeria')}}">Galeria</a></li>
              <li><h2 class="titulo" style="margin:10px;font-size:20px;font-weight:bold;">{{$registro->titulo}}</h2></li>
            </ul>
            <div class="tab-content">
                @include('admin.noticias._gallery')
            </div>
        </div>

    <!-- /. box -->
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/fileUploader/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('admin/plugins/fileUploader/jquery.fileupload.js') }}"></script>
<script src="{{ asset('admin/plugins/fileUploader/jquery.iframe-transport.js') }}"></script>
<script>
    $(function () {
        'use strict';

        var galleryCollection = $('.gallery-collection');

        // Initialize the jQuery File Upload widget:
        $('#fileupload_gallery').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            // formData:{'_token':'{{ csrf_token() }}}'},
            dataType:'json',
            url: "{{url('admin/noticias/'.$registro->id.'/galeria?_token='.csrf_token())}}",
            formData:{ id:{{$registro->id?$registro->id:'null'}}},
            add: function (e, data) {
                data.submit();
                $('#item-loading').show();
            },
            done: function(e, data){
                if( 'status' in data.result){
                    if(data.result.status=='error'){
                        $('#modal-error .modal-body p').text(data.result.message);
                        $('#modal-error').modal('show');
                    }
                    else if(data.result.status=='success'){
                        galleryCollection.append('<li class="gallery-item col-sm-2"><img src="{{asset('')}}'+data.result.message+'" class="img-responsive" title="Destaque"><div class="buttons-container"><button type="button" class="btn delete-button btn-danger" value="'+data.result.id+'" data-toggle="modal" data-target="#modal-danger"><i class="fa fa-close"></i></button></div></li>');
                        $('#modal-success .modal-body p').text('Todas as imagens foram salvas com sucesso!');
                        $('#modal-success').modal('show');

                    }
                }
            },
            fail:function(e,data) {
                if( data.result){
                    $('#modal-error .modal-body p').text(data.result.message);
                }
                else{
                    $('#modal-error .modal-body p').text('Um erro ocorreu durante o processo de upload da imagem e por essa razão a imagem ou imagens não foram salvas.');
                }
                $('#modal-error').modal('show');
            },
            always:function() {
                $('#item-loading').hide();
            }
        });

        var currentImgToDelete;
        $('.gallery-collection,#destaque-container').on( 'mouseover','.delete-button', function(event) {
            // on mouseover, the element can be the i or the button
            if(event.target.localName=='button')
                currentImgToDelete = event.target;  
            else 
                currentImgToDelete = event.target.parentNode;  
        });

        // Every time a new imagem is uploaded, the new button has to be reseted 
        // This way, we has less efford
        $('.gallery-collection,#destaque-container').on( 'click','.delete-button', function(event) {
            var tgt = null
            // check if the click is in the button or i element
            if(event.target.localName=='button')
                tgt = event.target;  
            else 
                tgt = event.target.parentNode;  

            if( tgt.className.indexOf('disabled')==-1 ){
                $('#modal-delete').modal('show');
            }
        });

        $('.delete-cancel').click(function(event) {
            currentImgToDelete = null;            
        });

        $('.delete-ok').click(function(event) {
            var url = '{{url("admin/noticias/".$registro->id."/galeria")}}/'+
                currentImgToDelete.value+"/delete";


            // Check if the button is already clicked
            if( event.target.className.indexOf('disabled')==-1 ){
                event.target.className = event.target.className+' disabled';

                $.get( url, null, function(data) {
                    $('#modal-delete').modal('hide');

                    // Remove the gallery item that is the button great parent
                    if( currentImgToDelete.value!=='0' ){
                        currentImgToDelete.parentNode.parentNode.remove();
                    }else{
                        currentImgToDelete.className = currentImgToDelete.className +' disabled';
                        $('#destaque-img').attr('src','http://via.placeholder.com/410x220');
                    }

                    // Show success modal
                    $('#modal-success .modal-body p').text('A imagem foi excluída com sucesso!');
                    $('#modal-success').modal('show');
                }).fail(function(data) { 
                    $('#modal-delete').modal('hide');

                    $('#modal-error .modal-body p').text('Não foi possível excluir a imagem selecionada.')
                    $('#modal-error').modal('show');
                 }).always(function(){
                    event.target.className = event.target.className.replace(' disabled','');
                 });
            }
        });

        $('#modal-delete').on('show.bs.modal', function() {
            var msg = 'Tem certeza que deseja excluir a imagem '+currentImgToDelete.value+'?'
            if(currentImgToDelete.value==='0')
            {
                msg = 'Tem certeza que deseja excluir a imagem de Destaque?';
            }
            
            $('#modal-delete .modal-body p').text(msg);
        });

        $('#modal-display').on('show.bs.modal', function(e) {
            var galeriaPath = $(e.relatedTarget).attr('data-ref');
            if(galeriaPath.length>15){
                $('#display-img').attr('src','{{asset("")}}'+galeriaPath);
                $('#display-img').show();
            }else{
                console.log('video');
                $('#display-video').attr('src','https://www.youtube.com/embed/'+galeriaPath).show();
                $('#display-video').show();
            }
        });

        $('#modal-display').on('hidden.bs.modal', function(e) {
            $('#display-img').hide();
            $('#display-video').hide();
        });


        $('#fileupload_destaque').fileupload({
            dataType:'json',
            url: "{{url('admin/noticias/'.$registro->id.'/galeria/destaque?_token='.csrf_token())}}",
            formData:{ id:{{$registro->id?$registro->id:'null'}}},
            add: function (e, data) {
                data.submit();
                $('#item-loading-destaque').show();
            },
            done: function(e, data){
                if( 'status' in data.result){
                    if(data.result.status=='error'){
                        $('#modal-error .modal-body p').text(data.result.message);
                        $('#modal-error').modal('show');
                    }
                    else if(data.result.status=='success'){
                        $('#destaque-img').attr('src','{{asset('')}}'+data.result.message.substring(1)+'?time='+Math.random());
                        $('#modal-success .modal-body p').text('A imagem de Destaque foi salva com sucesso');
                        $('#modal-success').modal('show');
                        $('.destaque-buttons .delete-button').removeClass('disabled');
                    }
                }
            },
            fail:function(e,data) {
                if( data.result){
                    $('#modal-error .modal-body p').text(data.result.message);
                }
                else{
                    $('#modal-error .modal-body p').text('Um erro ocorreu um erro ao tentar salvar da imagem e por essa razão a imagem não foi salva.');
                }
                $('#modal-error').modal('show');
            },
            always:function(){
                $('#item-loading-destaque').hide();
            }
        });

        $('#url-save').click(function(event) {
            $('#item-loading-destaque').show();

            if(event.target.className.indexOf('disabled')==-1)
            {
                $(event.target).addClass('disabled');
                $('#url-loading').show();
                $.get("{{url('admin/noticias/'.$registro->id.'/galeria/destaque?_token='.csrf_token())}}",
                    {url:$('#url').val()},
                    function(data) {
                        $('#modal-url').modal('hide');
                        if( 'status' in data){
                            if(data.status=='error'){
                                $('#modal-error .modal-body p').text(data.message);
                                $('#modal-error').modal('show');
                            }
                            else if(data.status=='success'){
                                $('#url').val('');
                                $('#destaque-img').attr('src','{{asset('')}}'+data.message.substring(1)+'?time='+Math.random());
                                $('#modal-success .modal-body p').text('A imagem de Destaque foi salva com sucesso');
                                $('#modal-success').modal('show');
                                $('.destaque-buttons .delete-button').removeClass('disabled');
                            }
                        }
                    }
                ,'json').fail(function(e,data) {
                    $('#modal-url').modal('hide');
                    if( data ){
                        $('#modal-error .modal-body p').text(data.message);
                    }
                    else{
                        $('#modal-error .modal-body p').text('Um erro ocorreu um erro ao tentar salvar da imagem e por essa razão a imagem não foi salva.');
                    }
                    $('#modal-error').modal('show');
                }).always(function(e,data){
                    $(event.target).removeClass('disabled');
                    $('#item-loading-destaque').hide();
                    $('#url-loading').hide();
                });
            }

        });


        $('#youtube-save').click(function(event) {
            var ytId = $('#youtube_input').attr('alt');
            if(event.target.className.indexOf('disabled')==-1)
            {
                $(event.target).addClass('disabled');
                $('#youtube-loading').show();
                $.get("{{url('admin/noticias/'.$registro->id.'/galeria/youtube?_token='.csrf_token())}}",
                    {youtube_id: ytId},
                    function(data) {
                        $('#modal-video').modal('hide');
                        if( 'status' in data){
                            if(data.status=='error'){
                                $('#modal-error .modal-body p').text(data.message);
                                $('#modal-error').modal('show');
                            }
                            else if(data.status=='success'){
                                $('#youtube_input').val('');
                                $('#youtube-frame').attr('src','https://www.youtube.com/embed/');
                                galleryCollection.append('<li class="gallery-item col-sm-2"><img src="https://img.youtube.com/vi/'+ytId+'/2.jpg" class="img-responsive" title="Destaque"><div class="buttons-container"><button type="button" class="btn delete-button btn-danger" value="'+data.id+'" data-toggle="modal" data-target="#modal-danger"><i class="fa fa-close"></i></button></div></li>')
                                $('#modal-success .modal-body p').text('O video do youtube foi salvo com sucesso');
                                $('#modal-success').modal('show');
                                $(event.target).removeClass('disabled');
                            }
                        }
                    }
                ,'json').fail(function(e,data) {
                    $('#modal-video').modal('hide');
                    if( data ){
                        $('#modal-error .modal-body p').text(data.message);
                    }
                    else{
                        $('#modal-error .modal-body p').text('Um erro ocorreu um erro ao tentar salvar o video do Youtube. Por favor tente mais tarde.');
                    }
                    $('#modal-error').modal('show');
                }).always(function(e,data){
                    $(event.target).removeClass('disabled');
                    $('#youtube-loading').hide();
                });
            }

        });

        $('#youtube_input').keyup(function(event) {
            var link = event.target.value,
            youtubeId = '';

            if(link!=='')
            {
                youtubeId = link.match(/v=([a-zA-Z0-9_-]+)/g);
                if(youtubeId && youtubeId.length>0)
                {
                    youtubeId = youtubeId[0].replace('v=','');
                    document.getElementById('youtube-frame')
                        .src='https://www.youtube.com/embed/'+youtubeId;
                    event.target.alt=youtubeId;
                }
            }
        });
    });
</script>
<script>
    
</script>
@endsection
