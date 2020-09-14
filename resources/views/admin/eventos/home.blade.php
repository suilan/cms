@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/eventos/create')}}" class="btn btn-primary pull-right">Novo Evento</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        @if( sizeof($registros)>0 )
        <table class="table">
            <tbody>
                <tr>
                    <!-- <th>Sel.</th> -->
                    <th>Usuário</th>
                    <th>Periodo</th>
                    <th>Status</th>
                    <th>Título</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($registros as $key => $value): ?>
                    <tr>
                        <!-- <td><input type="checkbox"></td> -->
                        <td>{{ $value->name }}</td>
                        <td>De {{date('d/m/Y H:i',strtotime($value->data_inicial))}} à {{date('d/m/Y H:i',strtotime($value->data_final))}}</td>
                        <td>
                            @if( $value->status==0 )
                                <span class="label label-danger">Rascunho</span>
                            @else
                                <span class="label label-success">Publicado</span>
                            @endif
                        </td>
                        <td>{{$value->titulo}}</td>
                        <td>
                            <a class="btn" target="_blank" href="{{url('eventos/'.$value->slug)}}" title="Participantes"><i style="font-size: 15px" class="fa fa-users"></i></a>
                            <a class="btn" target="_blank" href="{{url('eventos/'.$value->slug)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
                            <a class="btn" href="{{url('admin/eventos/'.$value->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                            <a class="btn" href="{{url('admin/eventos/'.$value->id)}}" data-method="delete" title="Excluir"
                              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                              <i style="font-size: 15px" class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
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
        {!! $registros->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
        
        @else
        {!! $registros->render() !!}
        @endif

    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
