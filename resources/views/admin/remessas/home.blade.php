@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
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
    <div class="box box-primary">
        <div class="box-header">
            <a href="{{url('admin/titulos/create')}}" class="btn btn-primary pull-right">Nova Remessa</a>
            <!-- <a href="{{url('admin/remessas/create')}}" class="btn btn-success pull-right" style="margin-right: 5px;">Subir Arquivo de Remessa</a> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table">
            <tbody>
                <tr>
                    <th>ID</th>
                    @if( $isAdmin )
                    <th>Cartório</th>
                    @endif
                    <th>Qtd. de Títulos</th>
                    <th>Status</th>
                    <th>Data Criação</th>
                    <th>Ações</th>
                </tr>
	            @foreach ($registros as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    @if( $isAdmin )
                    <td>{{ strtoupper($value->cartorio_nome) }}</td>
                    @endif
                    <td>{{ $value->qtd_titulos }}</td>
                    <td>
                        @if( !$value->cancelado)
                            <span class="label label-success">Válido</span>
                        @else
                            <span class="label label-danger">Cancelado</span>
                        @endif
                    </td>
                    <td>{{date('d/m/Y',strtotime($value->created_at))}}</td>
                    <td>
                        <a class="btn" target="_blank" href="{{url('admin/titulos?remessa='.$value->id.'&pesquisa=1')}}" title="Visualizar Títulos">
                            <i style="font-size: 15px" class="fa fa-search"></i>
                        </a>
                        <a class="btn" target="_blank" href="{{url('admin/remessas/'.$value->id).'/print'}}" title="Imprimir">
                            <i style="font-size: 15px" class="fa fa-print"></i>
                        </a>
                        <a class="btn" href="{{url('admin/remessas/'.$value->id.'/status')}}" title="{{$value->cancelado?'Validar':'Cancelar'}}" 
                        data-token="{{csrf_token()}}" data-confirm="Você deseja realmente {{$value->cancelado?'validar':'cancelar'}} este registro?">
                            <i style="font-size: 15px" class="fa fa-{{$value->cancelado?'check':'remove'}}"></i>
                        </a>
                        <a class="btn" href="{{url('admin/remessas/'.$value->id)}}" data-method="delete" title="Excluir"
                        data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                            <i style="font-size: 15px" class="fa fa-trash"></i>
                        </a>
                    </td>
	            @endforeach
                </tr>
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
