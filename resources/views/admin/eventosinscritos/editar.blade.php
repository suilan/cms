@extends('admin.template.main')
<style type="text/css">
    .center-cropped {
      width: 200px;
      height: 500px;
      background-position: center center;
      background-repeat: no-repeat;
    }
</style>
@section('content')
<!-- Your Page Content Here -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="titulo">{{$inscrito->nome?$inscrito->nome:"Nova Inscrição"}}</h2>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                   <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if( Session::get('certificado') )
                <div class="alert alert-info">Certificado enviado com sucesso!</div>
            @elseif( Session::get('sucesso') )
                <div class="alert alert-info">Seus dados foram salvos com sucesso!</div>
            @endif

            <!-- /.box-header -->
            <form action="{{url('admin/eventosinscritos'.($inscrito->cpf?'/'.$inscrito->cpf:''))}}" id="form_inscricao" method="post">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if( Request::segment(3)!="create" )
                        <input type="hidden" name="_method" value="put">
                    @endif

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">Nome*</label>
                            <div class="col-sm-6">
                                <input type="text" name="nome" id="nome" class="form-control" value="{{$inscrito->nome}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 45px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">CPF*</label>
                            <div class="col-sm-4">
                                <input type="text" name="cpf" id="cpf" class="form-control cpf-mask" value="{{$inscrito->cpf}}">
                            </div>

                            <label for="noticia" class="col-sm-1 control-label">RG</label>
                            <div class="col-sm-4">
                                <input type="text" name="rg" id="rg" class="form-control" value="{{$inscrito->rg}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 90px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">E-mail*</label>
                            <div class="col-sm-6">
                                <input type="email" name="email" id="email" class="form-control" value="{{$inscrito->email}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 135px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">Telefone</label>
                            <div class="col-sm-4">
                                <input type="text" name="telefone" id="telefone" class="form-control" value="{{$inscrito->telefone}}">
                            </div>

                            <label for="noticia" class="col-sm-1 control-label">Celular*</label>
                            <div class="col-sm-4">
                                <input type="text" name="celular" id="celular" class="form-control celular" value="{{$inscrito->celular}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 180px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">Estado*</label>
                            <div class="col-sm-4">
                                <select name="estado" id="estado" class="form-control select_estado">
                                    <option value="">-- Selecione o Estado --</option>
                                    @foreach($estados as $key => $value)
                                        <option value="{{$value->id}}" {{$inscrito->estado_id==$value->id?"selected":""}}>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="noticia" class="col-sm-1 control-label">Cidade*</label>
                            <div class="col-sm-4">
                                <select name="cidade" id="cidade" class="form-control select_cidade">
                                    <option value="">-- Selecione a cidade --</option>
                                    @foreach($cidades as $key => $value)
                                        <option class="estado_{{$value->estado_id}}" value="{{$value->id}}" {{$inscrito->cidade_id==$value->id?"selected":""}}>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 225px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-2 control-label">Empresa/Instituição*</label>
                            <div class="col-sm-4">
                                <input type="text" name="empresa" id="empresa" class="form-control" value="{{$inscrito->empresa}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 270px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">Endereço*</label>
                            <div class="col-sm-6">
                                <input type="text" name="endereco" id="endereco" class="form-control" value="{{$inscrito->endereco}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 315px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-1 control-label">Tipo da inscrição*</label>
                            <div class="col-sm-6">
                                <select name="inscricao" required="true" class="form-control">
                                    <option value="">--Selecione o tipo--</option>
                                    <option @if($inscrito->inscricao == 2) selected @endif value="1">Notário / Registrador: Gratuito</option>
                                    <option @if($inscrito->inscricao == 3) selected @endif value="2">Funcionário de Cartório: Gratuito</option>
                                    <option @if($inscrito->inscricao == 3) selected @endif value="3">Profissionais do Direito: Gratuito</option>
                                    <option @if($inscrito->inscricao == 3) selected @endif value="4">Estudante: Gratuito</option>
                                    <option @if($inscrito->inscricao == 3) selected @endif value="6">Outros: Gratuito</option>
                                </select>
                            </div>
                        </div>
                    </div>
			         @if($inscrito->comprovante_estudante != null && $inscrito->inscricao == 3 && $inscrito->comprovante_url == null)
                            <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Pagamento</label>
                                   <a href="#">Comprovante não enviado</a>
                            </div>
                            <div class="form-group" style="margin-top: 50px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Estudante</label>
                                   <a target="_blank" href="{!! url($inscrito->comprovante_estudante) !!}">Visualizar Comprovante Estudante</a>
                            </div>
                    @elseif($inscrito->comprovante_estudante == null && $inscrito->inscricao == 3 && $inscrito->comprovante_url == null)
                            <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Pagamento</label>
                                   <a href="#">Comprovante não enviado</a>
                            </div>
                            <div class="form-group" style="margin-top: 50px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Estudante</label>
                                   <a href="#">Comprovante de Estudante não enviado</a>
                            </div>      

                    @elseif($inscrito->comprovante_estudante == null && $inscrito->inscricao == 3 && $inscrito->comprovante_url != null)
                         <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Pagamento</label>
                                @if(strpos($inscrito->comprovante_url, 'pdf') !== false)
                                    <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante</a>
                                @else
                                   <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante Pagamento</a>
                                @endif
                            </div>
                            <div class="form-group" style="margin-top: 50px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Estudante</label>
                                   <a href="#">Comprovante de Estudante não enviado</a>
                            </div>

                    @elseif($inscrito->comprovante_estudante != null && $inscrito->inscricao == 3 && $inscrito->comprovante_url != null)
                           <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Pagamento</label>
                                @if(strpos($inscrito->comprovante_url, 'pdf') !== false)
                                    <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante</a>
                                @else
                                   <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante Pagamento</a>
                                @endif
                            </div>
                            <div class="form-group" style="margin-top: 50px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Estudante</label>
                                   <a target="_blank" href="{!! url($inscrito->comprovante_estudante) !!}">Visualizar Comprovante Estudante</a>
                            </div>
                            @if(strpos($inscrito->comprovante_url, 'pdf') !== false)
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="noticia" class="col-sm-1 control-label">Confirmar inscrição</label>
                                    <div class="col-sm-6">
                                        <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                                    </div>
                                </div>
                            @else
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="noticia" class="col-sm-1 control-label">Confirmar inscrição</label>
                                    <div class="col-sm-6">
                                        <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                                    </div>
                                </div>
                            @endif
                    @elseif($inscrito->comprovante_url != null && $inscrito->inscricao != 3 && $inscrito->inscricao != 5)
                              <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-1 control-label">Comprovante de Pagamento</label>
                                @if(strpos($inscrito->comprovante_url, 'pdf') !== false)
                                    <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante</a>
                                @else
                                   <a target="_blank" href="{!! url($inscrito->comprovante_url) !!}">Visualizar Comprovante Pagamento</a>
                                @endif
                            </div>
                            @if(strpos($inscrito->comprovante_url, 'pdf') !== false)
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="noticia" class="col-sm-1 control-label">Confirmar inscrição</label>
                                    <div class="col-sm-6">
                                        <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                                    </div>
                                </div>
                            @else
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="noticia" class="col-sm-1 control-label">Confirmar inscrição</label>
                                    <div class="col-sm-6">
                                        <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                                    </div>
                                </div>
                            @endif
                    @elseif($inscrito->comprovante_url == null && $inscrito->inscricao != 3 && $inscrito->inscricao != 5)
                         <div class="form-group" style="margin-top: 315px;">
                            <div class="col-sm-12">
                                <label for="noticia" class="col-sm-2 control-label">Comprovante</label>
                                <div class="col-sm-6">
                                    <a target="_blank" href="#">Comprovante não enviado</a>
                                </div>
                            </div>
                        </div>
                    @elseif($inscrito->comprovante_url != null && $inscrito->inscricao == 5)
                         <div class="form-group" style="margin-top: 315px;">
                                <label for="noticia" class="col-sm-2 control-label">Comprovante
                                   <a target="_blank" href="#">Não necessita de comprovante</a>
                                </label>
                            </div>
                            <div class="form-group" style="margin-top: 30px;">
                                    <label for="noticia" class="col-sm-2 control-label">Confirmar inscrição</label>
                                        <div class="col-sm-6">
                                            <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                                        </div>
                                    </label>
                                </div>
                    @endif 
                    <br />
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-12">
                            <label for="noticia" class="col-sm-2 control-label">Confirmar inscrição</label>
                            <div class="col-sm-6">
                                <input type="checkBox" value="1" name="confirmado" @if($inscrito->confirmado == 1) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                    </div>
                    <a href="{{url('admin/eventosinscritos')}}" class="btn">Voltar</a>
                </div>
            </form>
        <!-- /.box-footer -->
        </div>
    <!-- /. box -->
    </div>
</div>

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".celular").inputmask("(99) 99999-9999");
    });
</script>
<script type="text/javascript">
    $('.select_estado').change(function(event){
        $(".select_cidade option").each(function(index,element){
            if(element.className === 'estado_'+event.target.value){
                element.style.display="block";
            }
            else{
                element.style.display = "none";
            }
        });
    });
</script>
@endsection

@endsection
