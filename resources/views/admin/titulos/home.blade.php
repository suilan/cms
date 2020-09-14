@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
            <form>
                @include('admin.titulos.pesquisa')
            </form>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if($cartorio_id)
                <span><strong>Cartório</strong>: {{strtoupper($cartorios[$cartorio_id])}}</span>
            @endif
            <table class="table">
                <tbody>
                    <tr>
                        <th>Protocolo</th>
                        @if(!$cartorio_id)
                            <th>Cartorio</th>
                        @endif
                        <th>Remessa</th>
                        <th>Devedor</th>
                        <th>Emissão</th>
                        <th>Saldo</th>
                        <th>Espécie</th>
                        <th>Ações</th>
                    </tr>
	                @foreach ($registros as $key => $value)
                    <tr>
                        <td>{{ $value->protocolo }}</td>
                        @if(!$cartorio_id)
                            <td style="width: 306px;">{{ $value->cartorio_nome }}</td>
                        @endif
                        <td>{{ $value->remessa_id}}</td>
                        <td>{{ $value->documento}}<br>{{strtoupper($value->devedor_nome)}}</td>
                        <td>{{ $value->emissao}}</td>
                        <td>{{ 'R$ '.$value->saldo}}</td>
                        <td>{{ $value->especie_nome}}</td>
                        <td>
                    	    <a class="btn" target="_blank" href="{{url('admin/titulos/'.$value->id)}}" title="Imprimir"><i style="font-size: 15px" class="fa fa-print"></i></a>
                            @if(! $value->edital_id > 0)
                                <a class="btn" href="{{url('admin/titulos/'.$value->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                                <a class="btn" href="{{url('admin/titulos/'.$value->id)}}" data-method="delete" title="Excluir"
                                data-token="{{csrf_token()}}" data-confirm="Você deseja realmente deletar este registro?">
                                    <i style="font-size: 15px" class="fa fa-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
	                @endforeach
                </tbody>
            </table>
        </div>

        <!-- /.box-body -->
        <div class="box-footer clearfix" style="text-align: center">
            @if( Input::get('pesquisar') )
                {!! $registros->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
            @else
                {!! $registros->render() !!}
    	    @endif
        </div>
    </div>
    <!-- /.box -->
</div>
@endsection

@section('scripts')
<script>
    $("#documento").inputmask("999.999.999-99");

    // Change mask with the document selected
    previousDocument = "CPF";
    $('.ident').click(function() {
        
        // If is already selected, do nothing
        if( !$(this).hasClass('selected') ){

            if( this.innerText == "CPF"){
                $("#tipo_doc").val('cpf');
                $("#documento").inputmask("999.999.999-99");
            } else{
                $("#tipo_doc").val('cnpj');
                $("#documento").inputmask("99.999.999/9999-99");
            }
            // Remove current selected class from old element and add to the new selected label
            $('.ident.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    // Money mask
    $('#saldo').keyup(function() {
        console.log(this.value);
        this.value = this.value.replace(/[^0-9]/g,'');
        if(this.value.length>2)
        {
            this.value= this.value.substr(0,this.value.length-2)+','+this.value.substr(this.value.length-2, this.value.length)
        }
        else{
            this.value= this.value;
        }
    });
</script>
@endsection