@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="{{url('admin/legislacoes/create')}}" class="btn btn-primary pull-right">Nova Legislação</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table class="table">
        <tbody>
        <tr>
          <th>Título</th>
          <th>Status</th>
          <th>Categoria</th>
          <th></th>
        </tr>
  <?php foreach ($legislacao as $key => $value): ?>
        <tr>
          <td>{{$value->descricao}}</td>
          <td>
                @if( $value->status==0 )
                    <span class="label label-danger">Rascunho</span>
                @else
                    <span class="label label-success">Publicado</span>
                @endif
          </td>
          <td>{{$value->categoria}}</td>
          <td>
      <a class="btn" target="_blank" href="{{$value->arquivo_url?$value->arquivo_url:$value->arquivo}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{{url('admin/legislacoes/'.$value->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/legislacoes/'.$value->id)}}" data-method="delete" title="Excluir"
              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
              <i style="font-size: 15px" class="fa fa-trash"></i>
            </a>
          </td>
  <?php  endforeach; ?>
        </tr>
      </tbody>
   </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        @if( Input::get('pesquisar') )
            {!! $legislacao->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
        @else
            {!! $legislacao->render() !!}
  @endif
    </div>
  </div>
  <!-- /.box -->
</div>

@endsection
