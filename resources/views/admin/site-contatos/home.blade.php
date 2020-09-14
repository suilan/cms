@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            @if( Session::get('sucesso') )
                <div class="alert alert-info">O contato foi excluído com sucesso!</div>
            @endif
            <!-- <a href="{{url('admin/contatos/create')}}" class="btn btn-primary pull-right">Novo</a> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            @if( sizeof($registros)>0 )
            <table class="table">
                <tbody>
                    <tr>
                        <!-- <th>Sel.</th> -->
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Assunto</th>
                        <th>Mensagem</th>
                        <th>Enviado em</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($registros as $key => $value): ?>
                        <tr>
                            <!-- <td><input type="checkbox"></td> -->
                            <td>{{$value->nome}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->assunto}}</td>
                            <td>{{$value->mensagem}}</td>
                            <td>{{$value->created_at_br}}</td>
                            <td>
                                <a class="btn" target="_blank" href="{{url('admin/contatos/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
                                <!-- <a class="btn" href="{{url('admin/contatos/'.$value->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a> -->
                                <a class="btn" href="{{url('admin/contatos/'.$value->id)}}" data-method="delete" title="Excluir"
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
