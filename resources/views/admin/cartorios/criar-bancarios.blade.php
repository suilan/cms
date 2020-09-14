<div class="row">
    <div class="col-xs-7">
        <div class="form-group">
            <h3>Dados Bancários para pagamentos de Emolumentos</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        <div class="form-group">
            <label for="input" class="control-label">Favorecido </label>
            <input type="text" name="favorecido" id="favorecido" class="form-control" value="{{$cartorioBanco->favorecido}}" title="Favorecido">
        </div>
    </div>
    <div class="col-xs-4">
        <div style="margin-top:25px" class="form-group">
            <div class="ident-list">
                <div class="input-group ident-input">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            @if( !$cartorioBanco->tipo_favorecido )
                            <span class="type-text-ident">Identificação</span>
                            @elseif($cartorioBanco->tipo_favorecido==1)
                            <span class="type-text-ident">CPF</span>
                            @else
                            <span class="type-text-ident">CNPJ</span>
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a class="ident" href="#" data-type-value="1" >CPF</a>
                                <a class="ident" href="#" data-type-value="2">CNPJ</a>
                            </li>
                        </ul>
                    </span>
                    <input type="hidden" name="ident[1][type]" class="type-input" value="{{$cartorioBanco->tipo_favorecido}}" />
                    <input type="text" id="identificacao" name="ident[1][number]" class="form-control" value="{{$cartorioBanco->cpf_cnpj}}"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Banco </label>
            <select name="banco_id" id="banco_id" class="form-control">
                <option value="">-- Selecione --</option>
                @foreach($bancos as $key => $value)
                <option value="{{$value->id}}" {{$cartorioBanco->banco_id==$value->id?"selected":""}}>{{$value->nome}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Agência </label>
            <input type="text" name="agencia" id="agencia" class="form-control" value="{{$cartorioBanco->agencia}}"  title="Agência">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="">Tipo de Conta</label>
            <div class="radio">
                <label>
                    <input name="optionsConta" id="optionsRadios1" value="cc" {{!$cartorioBanco->conta_poupanca?"checked":""}} type="radio">
                    Corrente
                </label>
            </div>
            <div class="radio">
                <label>
                    <input name="optionsConta" id="optionsRadios2" value="cp" {{$cartorioBanco->conta_poupanca?"checked":""}} type="radio">
                    Poupança
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Conta </label>
            @if($cartorioBanco->conta_poupanca)
            <input type="text" name="conta" id="cc" class="form-control" value="{{$cartorioBanco->conta_poupanca}}"  title="Conta">
            @else
            <input type="text" name="conta" id="cc" class="form-control" value="{{$cartorioBanco->conta_corrente}}"  title="Conta">
            @endif
        </div>
    </div>
</div>
