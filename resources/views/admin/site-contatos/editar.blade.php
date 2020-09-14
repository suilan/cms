@extends('admin.template.main')
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="titulo" style="padding-left:15px;">{{$registro->nome}}</h2>
            </div>

            <!-- /.box-header -->
            <form action="{{url('admin/contatos/'.$registro->id)}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="put">

                <div class="box-body">
                    <!-- Titulo da Notícia -->
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-6">
                            <input type="text" name="email" id="email" class="form-control" value="{{$registro->email}}" readonly="">
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div class="form-group">
                        <label for="evento"  class="col-sm-2 control-label">Assunto</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" readonly="" name="assunto" value="{{$registro->assunto}}" class="form-control pull-right" >
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <!-- corpo da notícia -->
                    <div class="form-group">
                        <label for="conteudo" class="col-sm-2 control-label">Mensagem</label>
                        <div class="col-sm-6">
                            <textarea  readonly="" name="conteudo" class="form-control">{{$registro->mensagem}}</textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{url('admin/contatos')}}" class="btn btn-default">Voltar</a>
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
@endsection
