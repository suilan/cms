@extends('admin.template.main')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">{{ strtoupper($usuario->name) }} - CPF: {{$usuario->cpf}}</h3>
				</div>
				<div class="box-body">
					<dl>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-group">
									<dt>E-mail</dt>
									<dd>{{$usuario->email}}</dd>
								</div>
							</div>
							<div class="col-sm-2" style="margin-left: 40px">
								<div class="form-group">
									<dt>Data de Nascimento</dt>
									<dd>{{$usuario->data_nascimento}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-12">
						        <div class="form-group">
									<dt>Endereço</dt>
									<dd>{{$usuario->endereco}} N° {{$usuario->numero}}, {{$usuario->bairro}}
								 	- {{$usuario->cep}} - {{$usuario->cidade}}/{{$usuario->uf}}</dd>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-2">
						        <div class="form-group">
									<?php  if ($usuario->complemento){?>
										<dt>Complemento</dt>
										<dd>{{$usuario->complemento}}</dd>
									<?php }?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									<dt>Telefone</dt>
									<dd>{{$usuario->telefone}}</dd>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<dt>Celular 1</dt>
									<dd>{{$usuario->celular1}}</dd>
								</div>
							</div>
                        </div>
                        <div class="row">
							@foreach ($creden as $k=>$r)
								<div class="col-sm-3">
									<div class="form-group">
										<dt>{{ $r->tipo_imagem }}</dt>
										@if(strpos($r->path,".pdf"))
											<a target="_blank" href="{{ asset($r->path) }}">Visualizar Arquivo</a>
										@else
											<a target="_blank" href="{{ asset($r->path) }}">
												<img class="img-thumbnail rounded mx-auto d-block" src="{{ asset($r->path) }}" alt="Imagem para credenciamento"/>
											</a>
										@endif
									</div>
								</div>
							@endforeach
						</div>
						<div class="row">
							<div class="col-xs-12">
								<dt>Empresas Credenciadas</dt>
								<div class="box box-primary">
									<div class="box box-header">
										<div class="pull-left">
											<a href="{{ url('downloadExcelCredenIntimacaoEmpresa/xlsx?'.http_build_query(request()->input(),'','&').'&usuarioid='.$usuario->id)}}" class="btn btn-success pull-right" style="margin-left: 10px">Gerar Arquivo em Excel</a>
										</div>
										<div class="pull-right">
											<p>Status do Credenciamento</p>
											<form action="{{ url('admin/credenciamentorepresentante') }}" method="GET" id="formFilter">
												<input type="hidden" value="{{$usuario->id}}" name="userid"/>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" checked value="9">Todos
												</label>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" value="1">Credenciado
												</label>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" value="4">A Credenciar
												</label>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" value="2">Não Credenciado
												</label>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" value="5">Termo Aceite
												</label>
												<label class="radio-inline">
													<input type="radio" name="startusCreden" value="6">Termo não Aceite
												</label>
											</form>
										</div>
									</div>
									<!-- /.box-header -->
									<div class="box-body table-responsive no-padding">
										@if( sizeof($usuarioCredenciamento)>0 )
											<table class="table">
												<tbody>
													<tr>
														<th>Razão Social</th>
														<th>CNPJ</th>
														<th>E-mail</th>
														<th>Status</th>
														<th>Ações</th>
													</tr>
													<?php foreach ($usuarioCredenciamento as $key => $value): ?>
														<tr>
														<td>{{ strtoupper($value->razao) }}</td>
														<td>{{$value->cnpj}}</td>
														<td>{{ strtolower($value->email) }}</td>
														<td>
															@if($value->creden == 1)
																<span class="badge badge-success" style="background-color: #407020">Credenciado</span>
															@elseif($value->creden == 0)
																<span class="badge badge-danger" style="background-color: #ffc107">A Credenciar</span>
															@else
																<span class="badge badge-danger" style="background-color: #FF0000">Não Credenciado</span>
															@endif
														</td>
														<td>
															<a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->user_id."/".$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
															<a class="btn" target="_blank" href="{{ url('admin/segundavia') }}?pesquisar={{ substr($value->cnpj,1,9)}}&campo=credenpj&razao={{ $value->razao }}&cnpj={{ $value->cnpj }}" title="Visualizar"><i style="font-size: 15px" class="fa fa-file-o"></i></a>
															<a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id).'/0/edit '}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
															@if(Auth::user()->papel_id <= 2)
																<a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id).'/1/edit'}}" title="Credenciar" data-toggle="tooltip" data-placement="bottom" title="Credenciar"><i style="font-size: 15px; color: #407020" class="fa fa-thumbs-o-up"></i></a>
																<!-- Button trigger modal -->
																<button type="button" class="btn" title="Descredenciar" data-toggle="modal" data-target="#model_{{ $value->id }}" value="">
																		<span style="font-size: 15px; color: #FF0000" class="fa fa-thumbs-o-down" data-toggle="tooltip" data-placement="bottom" title="Descredenciar"></span>
																</button>
															
																<!-- Modal -->
																<div class="modal fade" id="model_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" role="dialog">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																				<div class="modal-header">
																						<h3 class="modal-title">Descredenciamento</h3>
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																							<span aria-hidden="true">&times;</span>
																						</button>
																					</div>
																			<form action="{{url('admin/credenciamentorepresentante/'.$value->id).'/2/edit'}}" style="display: inline">
																				<div class="modal-body">
																					<div class="form-group">
																						<label for="motivoDesc">Descreva o motivo do <strong style="color: red">Descredenciamento</strong></label>
																						<textarea name="motivoDesc" class="form-control" id="motivoDesc" rows="3"></textarea>
																					</div>
																				</div>
																				<div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
																					<button type="submit" class="btn btn-danger">Descredenciar</button>
																				</div>
																			</form>
																		</div>
																	</div>
																</div>
																<a class="btn" href="{{url('admin/credenciamentorepresentante/'.$value->id)}}" data-method="delete" 
																	data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
																	<i style="font-size: 15px" class="fa fa-trash"></i>
																</a>
															@endif
														</td>
														</tr>
													<?php  endforeach; ?>
												</tbody>
											</table>
										@else
											Não há usuários pendentes de credenciamento.
										@endif
									</div>
									<!-- /.box-body -->
							
									<div class="box-footer clearfix">
										<div class="row">
											<div class="col-sm-12 col-md-4 no-margin pull-left">
												<div class="dataTables_info" role="status" aria-live="polite" style="margin: 20px 0;">
													<strong>
														@if($usuarioCredenciamento->count() != 1)
															Visualizando {{$usuarioCredenciamento->count() * $usuarioCredenciamento->currentPage()}} de {{$usuarioCredenciamento->total()}}
														@else
															Visualizando {{$usuarioCredenciamento->total()}} de {{$usuarioCredenciamento->total()}}
														@endif
													</strong>
												</div>
											</div>
											<div class="col-sm-12 col-md-8 no-margin pull-right">
												@if( Input::get('pesquisar') )
													{!! $usuarioCredenciamento->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
												@elseif(Input::get('startusCreden'))
													{!! $usuarioCredenciamento->appends(['startusCreden' => Input::get('startusCreden')])->render() !!}
												@else
													{!! $usuarioCredenciamento->render() !!}
												@endif
											</div>    
										</div>
									</div>
								</div>
							</div>
						</div>
					</dl>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
				    <a href="{{url('admin/credenciamentoboleto')}}" class="btn">Voltar</a>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('input[type=radio][name=startusCreden]').change(function() {
            document.getElementById("formFilter").submit();
        });

        $('input:radio[name="startusCreden"]').filter('[value="{{ Input::get('startusCreden') }}"]').attr('checked', true);
    </script>
@endsection
