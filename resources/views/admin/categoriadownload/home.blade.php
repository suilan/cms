@extends('admin.template.main')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box box-header">
                    <a href="{{url('admin/categoriadownloads/create')}}" class="btn btn-primary pull-right">Nova Categoria de Download</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    @if( sizeof($categoriasDownload)>0 )
                        <table class="table">
                            <tbody>
                            <tr>
                                <!-- <th>Sel.</th> -->
                                <th>Descrição</th>
                                <th></th>
                            </tr>
                            <?php foreach ($categoriasDownload as $key => $value): ?>
                            <tr>
                                <!-- <td><input type="checkbox"></td> -->
                                <td>{{ $value->descricao }}</td>
                                <td>
                                    <a class="btn" target="_blank" href="{{url('categoriadownloads/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
                                    <a class="btn" href="{{url('admin/categoriadownloads/'.$value->id).'/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                                    <a class="btn" href="{{url('admin/categoriadownloads/'.$value->id)}}" data-method="delete" title="Excluir"
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
                {{--<div class="box-footer clearfix" style="text-align: center">--}}
                    {{--@if( Input::get('pesquisar') )--}}
                        {{--{!! $registros->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}--}}

                    {{--@else--}}
                        {{--{!! $registros->render() !!}--}}
                    {{--@endif--}}

                {{--</div>--}}
            </div>
            <!-- /.box -->
        </div>

@endsection
@stop
