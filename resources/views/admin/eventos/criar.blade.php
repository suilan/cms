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
            <form action="{{url('admin/eventos')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">
                    <!-- Titulo da Notícia -->
                    <div class="form-group">
                        <label for="evento" class="col-sm-2 control-label">Título do Evento*</label>
                        <div class="col-sm-6">
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{Input::old('titulo')}}" maxlength="255">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label for="evento"  class="col-sm-2 control-label">Período*</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" name="periodo" id="periodo"  class="form-control pull-right" value="{{Input::old('periodo')}}">
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!-- Status da Notícia -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="status" id="status1" value="0" type="radio" {{Input::old('status')?'':'checked=""'}}>
                                <span class="label label-danger">Rascunho</span>
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="status" id="status2" value="1" type="radio" {{Input::old('status')?'':'checked=""'}}>
                                <span class="label label-success">Publicado</span>
                            </label>
                        </div>
                    </div>
                    <br/>
                    <!-- origem da imagem a ser usada na notícia -->
                    <div class="form-group">
                        <label for="imagem" class="col-sm-2 control-label">Origem da Imagem</label>
                        <br/>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipoimagem" id="tipoimagem1" value="img-url" type="radio" {{(!Input::old('tipoimagem') || Input::old('tipoimagem')=='img-url')?'checked=""':''}}>
                                Copiar URL
                            </label>
                        </div>
                        <div class="radio" style="padding: 0 0 0 15px;">
                            <label>
                                <input name="tipoimagem" id="tipoimagem2" value="img-file" type="radio" {{Input::old('tipoimagem')=='img-file'?'checked=""':''}}>
                                Adicionar Arquivo
                            </label>
                        </div>
                    </div>
                    <div class="form-group img-input img-url">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> URL da imagem
                            <input type="text" id="imagemurl" name="imagemurl" style="width:700px;padding-left:5px;" value="{{Input::old('imagemurl')}}">
                        </div>
                    </div>
                    <div class="form-group img-input img-file" style="display:none;">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Imagem &nbsp;
                            <input type="hidden" name="imgarq" value="false">
                            <input type="file" id="imagemarquivo" name="imagemarquivo">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                    <!-- corpo da notícia -->
                    <div class="form-group">
                        <textarea id="editor" placeholder="Digite uma nova notícia" name="conteudo" class="form-control" style="height: 300px;">{{Input::old('conteudo')}}</textarea>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Salvar</button>
                    </div>
                    <button type="reset" class="btn btn-danger descartar"><i class="fa fa-times"></i> Descartar</button>
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

@section('scripts')
<script>
    $('#periodo').daterangepicker({
        timePicker:true,  //mostra o painel para escolher a hora
        timePicker24Hour:true, // mostra a hora em formato de 24
        timePickerIncrement: 1, //aparece uma option pra cada minuto
        format:'DD/MM/YYYY HH:mm', // formato da hora
        locale:{
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'De',
                toLabel: 'Para',
                weekLabel: 'S',
                customRangeLabel: 'Periodo',
                daysOfWeek: moment.weekdaysMin(),
                monthNames: moment.monthsShort(),
                firstDay: moment.localeData()._week.dow
            }
    });
</script>

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
