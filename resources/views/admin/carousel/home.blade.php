@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
            <a href="{{url('admin/carousel/create')}}" class="btn btn-primary pull-right">Nova Imagem</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
    @include('admin.template.alerts')

	@if( sizeof($carousel)>0 )
      <table class="table table-hover">
        <tbody><tr>
          <th>ID</th>
          <th style="width:70px;">Imagem</th>
          <th>Título</th>
	        <th>Usuário</th>
          <th>Data Criação</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
	     @foreach ($carousel as $key => $value)
        <tr>
          <td>{{$value->id}}</td>
          <td><img style="background-color: #3c8dbc;" src="{{asset($value->getOtherImage(150,50))}}" alt=""/></td>
          <td>{{$value->titulo}}</td>
	         <td>{{ $value->name }}</td>
          <td>{{date('d/m/Y',strtotime($value->created_at))}}</td>
          <td>
                @if( $value->status==0 )
                    <span class="label label-danger">Rascunho</span>
                @else
                    <span class="label label-success">Publicado</span>
                @endif
          </td>
          <td>
            <a class="btn" href="{{url('admin/carousel/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{{url('admin/carousel/'.$value->id).'/edit'}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/carousel/'.$value->id)}}" data-method="delete" title="Excluir"
              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
              <i style="font-size: 15px" class="fa fa-trash"></i>
            </a>

          </td>
	     @endforeach
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
        {!! $carousel->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
        @else
        {!! $carousel->render() !!}
        @endif
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
