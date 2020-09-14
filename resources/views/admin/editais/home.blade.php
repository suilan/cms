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
        <div class="box box-header">
            <a href="{{url('admin/editais/create')}}" class="btn btn-primary pull-right">Gerar Edital</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table">
            <tbody>
                <tr>
                    <th>ID</th>
                    @if( $isAdmin )
                    <th>Cartório</th>
                    @endif
                    <th>Qtd. de Títulos</th>
                    <th>Qtd. de Remessas</th>
                    <th>Status</th>
                    <th>Data</th>
                    <!-- <th>Ações</th> -->
                </tr>
              @foreach ($registros as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    @if( $isAdmin )
                    <td>{{ strtoupper($value->cartorio_nome) }}</td>
                    @endif
                    <td>{{ $value->qtd_titulos }}</td>
                    <td>{{ $value->qtd_remessas }}</td>
                    <td>
                        @if( !$value->cancelado)
                            <span class="label label-success">Válido</span>
                        @else
                            <span class="label label-danger">Cancelado</span>
                        @endif
                    </td>
                    <td>{{date('d/m/Y',strtotime($value->created_at))}}</td>
                    <td>
                        <a class="btn" target="_blank" href="{{url('admin/editais/'.$value->id)}}" title="Montar pdf do edital"><i style="font-size: 15px" class="fa fa-print"></i></a>
                        <a class="btn" href="{{url('admin/editais/'.$value->id.'/status')}}"
                        data-token="{{csrf_token()}}" data-confirm="Você deseja realmente {{$value->cancelado?'validar':'cancelar'}} este registro?" title="Alterar status do edital">
                            <i style="font-size: 15px" class="fa fa-{{$value->cancelado?'check':'remove'}}"></i>
                        </a>
<!--                         <a class="btn" href="{{url('admin/editais/'.$value->id)}}" data-method="delete"
                          data-token="{{csrf_token()}}" data-confirm="Você deseja realmente deletar este registro?">
                          <i style="font-size: 15px" class="fa fa-trash"></i>
                        </a> -->
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
