@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/eventosinscritos/create')}}" class="btn btn-primary pull-right" style="margin-left: 10px">Novo Participante</a>
            <a href="{{ url('downloadExcel/xlsx?'.http_build_query(request()->input(),'','&'))}}" class="btn btn-success pull-right" style="margin-left: 10px">Gerar Arquivo em Excel</a>
            <a href="{{ url('downloadExcelCreden/xlsx?'.http_build_query(request()->input(),'','&'))}}" class="btn btn-success pull-right">Gerar Arquivo em Excel Credenciados</a>
	      <h3>{{$qtd_inscritos}} Cadastrados | {{$qtd_confirmados}} Confirmados</h3>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        @if( sizeof($inscritos)>0 )
        <table class="table">
            <tbody>
                <tr>
                    <!-- <th>Sel.</th> -->
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>CPF</th>
                    <th>Contato</th>
                    <th>Data Inscrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($inscritos as $key => $value): ?>
                    <tr>
                        <!-- <td><input type="checkbox"></td> -->
                        <td>{{ strtoupper($value->nome) }}</td>
                        <td>{{ $value->cidade }}</td>
                        <td>{{ $value->cpf }}</td>
                        <td>{{ $value->celular }}</td>
			            <td>{{ $value->data_insc}}</td>
                        <td>
				            @if ($value->confirmado == 1)
                                <p style="color: blue">Inscrição Confirmada</p>
                            @elseif($value->inscricao == 5 )
                                <p style="color: blue">Cortesia</p>
                            @elseif ($value->confirmado == null)
                                <p style="color: red">Aguardando Confirmar</p>
                             @elseif ($value->comprovante_url != null && $value->inscricao != 3 && $value->inscricao != 5 )
                                <p style="color: green">Comprovante de Pagamento enviado</p>
                            @elseif($value->comprovante_url != null && $value->inscricao == 3 && $value->comprovante_estudante == null)
                                <p style="color: red">Aguardando Comprovante de Estudante</p>
                            @elseif($value->comprovante_url == null && $value->inscricao == 3 && $value->comprovante_estudante != null)
                                <p style="color: red">Aguardando Comprovante de Pagamento</p>
                            @elseif($value->comprovante_url != null && $value->inscricao == 3 && $value->comprovante_estudante != null)
                                <p style="color: green">Todos os Comprovantes enviados</p>
                            @elseif($value->comprovante_url == null && $value->inscricao == 3 && $value->comprovante_estudante == null)
                                <p style="color: red">Aguardando Comprovantes</p>
                            @elseif($value->comprovante_url == null && $value->inscricao != 3 && $value->inscricao != 5 )
                                <p style="color: red">Aguardando Comprovante de Pagamento</p> 
                            @endif
                        </td>
                        <td>
                            @if($value->confirmado !== 1)
                                <form action="{{url('admin/eventosinscritos/'.$value->cpf)}}" id="form_upload_{{$value->id}}" method="post" enctype="multipart/form-data" style="float: left;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="put">

                                        <label for='selecao-arquivo_{{$value->id}}' style="margin-top: 2px; @if ($value->comprovante_url != null) display: none @endif">
                                            <i style="font-size: 15px" class="fa fa-upload btn"></i>
                                        </label>

                                        <input id='selecao-arquivo_{{$value->id}}' name="comprovante" type='file' style="display: none;" />

                                        <label style="display: none;"></label>

                                        <label for='selecao-estudante-arquivo_{{$value->id}}' style="margin-top: 2px; @if (($value->inscricao == 4 && $value->comprovante_estudante != null) || $value->inscricao != 4) display: none; @endif">
                                            <i style="font-size: 15px" class="fa fa-graduation-cap btn"></i>
                                        </label>

                                        <input id='selecao-estudante-arquivo_{{$value->id}}' name="comprovante_estudante" type='file' style="display: none;">
                                        
                                        <label for='selecao-certificado-arquivo_{{$value->id}}' style="margin-top: 2px; @if ($value->certificado != null) display: none; @endif">
                                            <i style="font-size: 15px" class="fa fa-certificate btn"></i>
                                        </label>

                                        <input id='selecao-certificado-arquivo_{{$value->id}}' name="certificado" type='file' style="display: none;">
                                </form> 
                           @endif

                            <a class="btn" href="{{url('admin/eventosinscritos/'.$value->cpf)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
                            <a class="btn" href="{{url('admin/eventosinscritos/'.$value->cpf).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                            <a class="btn" href="{{url('admin/eventosinscritos/'.$value->cpf)}}" data-method="delete" title="Excluir"
                              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                              <i style="font-size: 15px" class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <script type="text/javascript">
                        document.getElementById("selecao-arquivo_{{$value->id}}").onchange = function() {
                            document.getElementById("form_upload_{{$value->id}}").submit();
                        };

                        document.getElementById("selecao-arquivo_{{$value->id}}").onchange = function() {
                            document.getElementById("form_upload_{{$value->id}}").submit();
                        };

                        document.getElementById("selecao-certificado-arquivo_{{$value->id}}").onchange = function() {
                            document.getElementById("form_upload_{{$value->id}}").submit();
                        };
                    </script>
                <?php  endforeach; ?>
            </tbody>
        </table>
        @else
            Nenhum registro encontrado.
        @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        @if( Input::get('pesquisar') )
        {!! $inscritos->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}

        @else
        {!! $inscritos->render() !!}
        @endif
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
