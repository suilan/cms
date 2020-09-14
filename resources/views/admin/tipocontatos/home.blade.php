@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/tipocontatos/create')}}" class="btn btn-primary pull-right">Novo tipo de contato</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table class="table">
        <tbody><tr>
	  <th>Sel.</th>
          <th>Id</th>
          <th>Tipo de Contato</th>
          <th>Ações</th>
        </tr>
	<?php foreach ($tiposContatos as $key => $value): ?>
        <tr>
	  <td><input type="checkbox"></td>
          <td>{{$value->id}}</td>
          <td>{{$value->nome}}</td>
          <td>
            <a class="btn" href="{{url('admin/tipocontatos/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{{url('admin/tipocontatos/'.$value->id).'/edit'}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/tipocontatos/'.$value->id)}}" data-method="delete" title="Excluir"
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
        {!! $tiposContatos->render() !!}
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
