@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/perfil/create')}}" class="btn btn-primary pull-right">Novo</a>
        </div>
        @if( Session::get('sucesso') )
            <div class="alert alert-info">A operação foi realizada com sucesso!</div>
        @endif
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
      <table class="table">
        <tbody><tr>
          <th>Id</th>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
    <?php foreach ($registros as $key => $value): ?>
        <tr>
          <td>{{$value->id}}</td>
          <td>{{$value->nome}}</td>
          <td>{{$value->descricao}}</td>
          <td>
            @if($value->status)
            <small class="label label-success">Ativo</small>
            @else
            <small class="label label-danger">Inativo</small>
            @endif
          </td>
          <td>
            <a class="btn" href="{{url('admin/perfil/'.$value->id).'/edit'}}" title="Editar">
                <i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/perfil/'.$value->id)}}" data-method="delete" title="Excluir"
              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
              <i style="font-size: 15px" class="fa fa-trash"></i>
            </a>
          </td>
        </tr>
    <?php  endforeach; ?>
      </tbody>
   </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        {!! $registros->render() !!}
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
