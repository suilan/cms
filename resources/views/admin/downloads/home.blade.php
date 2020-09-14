@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/downloads/create')}}" class="btn btn-primary pull-right">Novo Arquivo para Download</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
	@if( sizeof($downloads)>0 )
      <table class="table">
        <tbody><tr>
	        <th>Usuário</th> 
          <th>Data de Criação</th>
          <th>Data de Modificação</th>
          <th>Status</th>
          <th>Título</th>
          <th>Ações</th>
        </tr>
	<?php foreach ($downloads as $key => $value): ?>
        <tr>
          <td>{{$value->name}}</td>
          <td>{{date('d/m/Y - H:m',strtotime($value->created_at))}}</td>
          <td>{{date('d/m/Y - H:m',strtotime($value->updated_at))}}</td>
          <td>
                @if( $value->status==0 )
                    <span class="label label-danger">Não Publicado</span>
                @else
                    <span class="label label-success">Publicado</span>
                @endif
          </td>
          <td>{{$value->titulo}}</td>
          <td>
            <a class="btn" target="_blank" href="{{url('admin/downloads/'.$value->id)}}"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{{url('admin/downloads/'.$value->id).'/edit'}}"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/downloads/'.$value->id)}}" data-method="delete" 
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
        {!! $downloads->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
	@else
        {!! $downloads->render() !!}
        @endif
       
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
