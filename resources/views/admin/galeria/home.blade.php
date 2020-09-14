@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/galeria/create')}}" class="btn btn-primary pull-right">Nova Galeria de Imagens</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
	@if( sizeof($geleria)>0 )
      <table class="table">
        <tbody><tr>
	        <th>Álbum</th>
          <th>Data Criação</th>
          <th>Status</th>
          <th></th>
        </tr>
	<?php foreach ($geleria as $key => $value): ?>
        <tr>
	         <td>{{ $value->descricao }}</td>
          <td>{{date('d/m/Y',strtotime($value->created_at))}}</td>
          <td>
                @if( $value->status==0 )
                    <span class="label label-danger">Rascunho</span>
                @else
                    <span class="label label-success">Publicado</span>
                @endif
          </td>
          <td>
            <a class="btn" href="{{url('admin/galeria/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{{url('admin/galeria/'.$value->id).'/edit'}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/galeria/'.$value->id)}}" data-method="delete" title="Excluir"
              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
              <i style="font-size: 15px" class="fa fa-trash"></i>
            </a>

          </td>
	<?php  endforeach; ?>
        </tr>
      </tbody>
   </table>
        @else
        Nenhum registro encontrado.
        @endif

    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        @if( Input::get('pesquisar') )
            {!! $geleria->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
        @else
            {!! $geleria->render() !!}
        @endif
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
