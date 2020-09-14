@extends('admin.template.main')
@section('content')
<style>
    th{
        text-align: center;
    }
    td{
        text-align: center;        
    }
    table{
        border-color: #3c8dbc;
    }
</style>
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        @if(Auth::user()->papel_id === 8)
            <div class="box box-header">
                <a href="{{url('admin/representante/create')}}" class="btn btn-primary pull-right"><strong>CREDENCIAR NOVA EMPRESA</strong></a>
            </div>
        @endif
    <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            @if(sizeOf($registros) > 0)
                <table class="table ">
                    <tbody>
                        <tr>
                            <th>Razão</th>
                            <th>CNPJ</th>
                            <th>Contato</th>
                            <th>Status</th>
                            <th>Intimações</th>
                            <th>Ações</th>
                        </tr>
                        @foreach ($registros as $item)
                            <tr>
                                <td>{{ strtoupper($item->razao) }}</td>
                                <td>{{ $item->cnpj }}</td>
                                <td>{{ $item->telefone }}</td>
                                @if ($item->creden == 0)
                                    <td><span class='badge bg-yellow'>EM ANÁLISE</span></td>
                                @elseif ($item->creden == 2)
                                    <td><span class='badge bg-red'>NEGADO</span></td>
                                @else
                                    <td><span class='badge bg-green'>ATIVO</span></td>
                                @endif
                                <td>
                                    @if ($item->creden == 1)
                                        <a class="btn btn-primary" target="_blank" href="{{ url('admin/segundavia') }}?pesquisar={{ substr($value->cnpj,0,10)}}&campo=credenpj&razao={{ $value->razao }}&cnpj={{ $value->cnpj }}" title="Visualizar">Visualizar intimações</a>
                                        {{-- <a class="btn" target="_blank" href="{{ url('admin/segundavia') }}?pesquisar={{ substr($item->cnpj,1,9)}}&campo=credenpj" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a> --}}
                                    @endif
                                    {{-- @if($item->creden == 0 || $item->creden == 2) --}}
                                        <a class="btn" href="{{ url('admin/representante/'.$item->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                                    {{-- @endif --}}
                                    <a class="btn" href="{{ url('admin/representante/'.$item->id) }}" data-method="delete" title="Excluir"
                                        data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                                        <i style="font-size: 15px" class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Nenhum registro encontrado</p>
            @endif
        </div>
  </div>
  <!-- /.box -->
</div>
@endsection
