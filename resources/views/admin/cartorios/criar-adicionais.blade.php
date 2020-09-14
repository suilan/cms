<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <label for="optradio" class="control-label">O cartório é informatizado?</label>
            <label class="radio-inline">
                <input {{$cartorio->informatizado?"checked":""}} id="optSim" type="radio" name="optradio" value="1">Sim
            </label>
            <label class="radio-inline">
                <input {{$cartorio->informatizado?"":"checked"}} id="optNao" type="radio" name="optradio" value="0">Não
            </label>
        </div>
    </div>
</div>
<div id="fornecedor" style="{{$cartorio->informatizado?"":"display:none;"}}" class="row">
    <h3>Empresa Fornecedora do Software</h3>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="empreFornNome" class="control-label">Empresa</label>
                <input type="text" name="empreFornNome" id="empreFornNome" class="form-control" value="{{$cartorio->empresainfo}}" title="Empresa Fornecedora do Software">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="input" class="control-label">Telefone </label>
                <input type="text" name="empreFornTel" id="empreFornTel" class="form-control telefone" value="{{$cartorio->contatoinfo}}"  title="Empresa Fornecedora do Software">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <div class="form-group">
                <label for="input" class="control-label">Responsável </label>
                <input type="text" name="empreFornResp" id="empreFornResp" class="form-control" value="{{$cartorio->responsavelinfo}}" title="Empresa Fornecedora do Software">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <label for="">Atribuições Informatizadas</label>
            <br/>
            @foreach($tipoAtribuicoes as $key => $value)
                <div class="checkbox atrib-info" style="{{$value->marcado?"":"display:none;"}}" >
                    <label>
                        <input type="checkbox" name="informatizado[{{$value->id}}]" value="{{$value->id}}" {{$value->informatizado?"checked":""}} class="">
                        {{$value->nome}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="#" class="btn btn-voltar">Voltar</a>
        <button type="button" class="btn btn-primary pull-right btn-form-adicionais">Continuar</button>
    </div>
</div>
