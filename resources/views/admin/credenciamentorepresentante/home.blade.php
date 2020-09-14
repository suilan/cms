@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    @if( Session::get('sucesso') )
        <div class="alert alert-info">Operação realizada com sucesso.</div>
    @endif
    <div class="box box-primary">
        <div class="box box-header">
            <div class="pull-left">
                <a href="{{ url('downloadExcelCredenIntimacaoEmpresa/xlsx?'.http_build_query(request()->input(),'','&'))}}" class="btn btn-success pull-right" style="margin-left: 10px">Gerar Arquivo em Excel</a>
            </div>

            <form action="{{ url('admin/credenciamentorepresentante') }}" method="GET" id="formFilter">
                <div class="pull-right" style="height: 77px">
                    <button class="btn btn-primary" type="submit" style="margin-top:24px">Filtrar</button>
                </div>

                <div class="pull-right"  style="margin-right: 40px">
                    <p><strong>Status da Impressão</strong></p>
                    <label class="radio-inline">
                        <input type="radio" name="statusImpressao" checked value="9">Todos
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="statusImpressao" value="1">Impresso
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="statusImpressao" value="4">Não Impresso
                    </label>
                </div>
                <div class="pull-right" style="margin-right: 40px">
                    <p><strong>Vencimento</strong></p>
                    <label class="radio-inline">
                        <input type="radio" name="statusVencimento" checked value="9">Todos
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="statusVencimento" value="1">Vencido
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="statusVencimento" value="4">A vencer
                    </label>
                </div>
                <div class="pull-right"  style="margin-right: 40px">
                    <p>Status do Credenciamento</p>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" checked value="9">Todos
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" value="1">Credenciado
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" value="4">A Credenciar
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" value="2">Não Credenciado
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" value="5">Termo Aceite
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="startusCreden" value="6">Termo não Aceite
                    </label>
                </div>
            </form>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            @if( sizeof($usuarioCredenciamento)>0 )
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>E-mail</th>
                            <th>Aceite do Termo</th>
                            <th>Status</th>
                            <th>Intimações</th>
                            <th>Ações</th>
                        </tr>
                        <?php foreach ($usuarioCredenciamento as $key => $value): ?>
                            <tr>
                            <td>{{ strtoupper($value->razao) }}</td>
                            <td>{{$value->cnpj}}</td>
                            <td>{{ strtolower($value->email) }}</td>
                            <td>{{ $value->adesao_at != null ? date('d/m/Y H:i:s', strtotime($value->adesao_at)) : null }}</td>
                            <td>
                                @if($value->creden == 1)
                                    <span class="badge badge-success" style="background-color: #407020">Credenciado</span>
                                @elseif($value->creden == 0)
                                    <span class="badge badge-danger" style="background-color: #ffc107">A Credenciar</span>
                                @else
                                    <span class="badge badge-danger" style="background-color: #FF0000">Não Credenciado</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" target="_blank" href="{{ url('admin/segundavia') }}?pesquisar={{ substr($value->cnpj,0,10)}}&campo=credenpj&razao={{ $value->razao }}&cnpj={{ $value->cnpj }}" title="Visualizar">Visualizar intimações</a>
                            </td>
                            <td>
                                <a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->user_id."/".$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
                                {{-- <a class="btn" target="_blank" href="{{ url('admin/segundavia') }}?pesquisar={{ substr($value->cnpj,0,10)}}&campo=credenpj&razao={{ $value->razao }}&cnpj={{ $value->cnpj }}" title="Visualizar"><i style="font-size: 15px" class="fa fa-file-o"></i></a> --}}
                                <a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id).'/0/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                                @if(Auth::user()->papel_id <= 2)
                                    <a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id).'/1/edit'}}" title="Credenciar" data-toggle="tooltip" data-placement="bottom" title="Credenciar"><i style="font-size: 15px; color: #407020" class="fa fa-thumbs-o-up"></i></a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn" title="Descredenciar" data-toggle="modal" data-target="#model_{{ $value->id }}" value="">
                                            <span style="font-size: 15px; color: #FF0000" class="fa fa-thumbs-o-down" data-toggle="tooltip" data-placement="bottom" title="Descredenciar"></span>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="model_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                    <div class="modal-header">
                                                            <h3 class="modal-title">Descredenciamento</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                <form action="{{url('admin/credenciamentorepresentante/'.$value->id).'/2/edit'}}" style="display: inline">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="motivoDesc">Descreva o motivo do <strong style="color: red">Descredenciamento</strong></label>
                                                            <textarea name="motivoDesc" class="form-control" id="motivoDesc" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-danger">Descredenciar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id)}}" data-method="delete" 
                                        data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                                        <i style="font-size: 15px" class="fa fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                            </tr>
                        <?php  endforeach; ?>
                    </tbody>
                </table>
            @else
                Não há usuários pendentes de credenciamento.
            @endif
        </div>
        <!-- /.box-body -->

        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-12 col-md-4 no-margin pull-left">
                    <div class="dataTables_info" role="status" aria-live="polite" style="margin: 20px 0;">
                        <strong>
                            @if($usuarioCredenciamento->count() != 1)
                                Visualizando {{$usuarioCredenciamento->count() * $usuarioCredenciamento->currentPage()}} de {{$usuarioCredenciamento->total()}}
                            @else
                                Visualizando {{$usuarioCredenciamento->total()}} de {{$usuarioCredenciamento->total()}}
                            @endif
                        </strong>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 no-margin pull-right">
                    @if( Input::get('pesquisar') )
                        {!! $usuarioCredenciamento->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
                    @elseif(Input::get('startusCreden'))
                        {!! $usuarioCredenciamento->appends(['startusCreden' => Input::get('startusCreden')])->render() !!}
                    @else
                        {!! $usuarioCredenciamento->render() !!}
                    @endif
                </div>    
            </div>
        </div>
    </div>
  <!-- /.box -->
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('input:radio[name="startusCreden"]').filter('[value="{{ Input::get('startusCreden') }}"]').attr('checked', true);
        $('input:radio[name="statusImpressao"]').filter('[value="{{ Input::get('statusImpressao') }}"]').attr('checked', true);
        $('input:radio[name="statusVencimento"]').filter('[value="{{ Input::get('statusVencimento') }}"]').attr('checked', true);
    </script>
@endsection