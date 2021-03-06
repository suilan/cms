@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
            <a href="{{url('admin/especies/create')}}" class="btn btn-primary pull-right">Novo</a>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      @if( Session::get('sucesso') )
          <div class="callout callout-info"><i class="fa fa-info-circle"></i> Seus dados foram salvos com sucesso!</div>
      @endif
      <table class="table">
        <tbody><tr>
          <th>ID</th>
          <th>Cód</th>
          <th>Espécies</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
        @foreach ($especies as $key => $value)
        <tr>
          <td>{{$value->id}}</td>
          <td>{{$value->codigo}}</td>
          <td>{{$value->nome}}</td>
          <td>
            @if($value->status)
            <small class="label label-success">Publicado</small>
            @else
            <small class="label label-danger">Não Publicado</small>
            @endif
          </td>
          <td>
            <a class="btn" href="{{url('admin/especies/'.$value->id).'/edit'}}" title="Editar">
                <i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{{url('admin/especies/'.$value->id)}}" data-method="delete" title="Excluir"
              data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
              <i style="font-size: 15px" class="fa fa-trash"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
   </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        {!! $especies->render() !!}
    </div>
  </div>
  <!-- /.box -->
</div>
@endsection
