<div class="row">
  <div class="col-xs-6">
    <div class="form-group">
      <label for="input" class="control-label">Nome do Cartório* </label>
      <input type="text" name="nome" id="nome" class="form-control" value="{{$cartorio->nome}}" title="Cartório">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label for="input" class="control-label">CNPJ</label>
      <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{$cartorio->cnpj}}" title="CNPJ">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-2">
    <div class="form-group">
      <label for="input" class="control-label">CEP* </label>
      <input type="text" name="cep" id="cep" class="cep form-control" data-grupo="localizacao" value="{{$cartorio->cep}}" title="CEP">
    </div>
  </div>
  <div class="col-xs-7">
    <div class="form-group">
      <label for="input" class="control-label">Cidade* </label>
      <input readonly="true" type="text" name="cidadeNome" id="cidade" class="cidade localizacao form-control" value="{{$cartorio->cidade}}" title="Cidade">
      <input type="hidden" name="cidadeIBGE" id="cidadeIBGE" class="ibge localizacao form-control" value="{{$cartorio->ibge}}" title="Cidade">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-5">
    <div class="form-group">
      <label for="input" class="control-label">Endereço* </label>
      <input type="text" name="endereco" id="endereco" class="endereco localizacao form-control" value="{{$cartorio->endereco}}" title="Endereço">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label for="input" class="control-label">Bairro* </label>
      <input type="text" name="bairro" id="bairro" class="bairro localizacao form-control" value="{{$cartorio->bairro}}" title="Bairro">
    </div>
  </div>
  <div class="col-xs-1">
    <div class="form-group">
      <label for="input" class="control-label">Nº* </label>
      <input type="text" name="numero" id="numero" class="form-control" value="{{$cartorio->numero}}" title="Número">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-9">
    <div class="form-group">
      <label for="input" class="control-label">Complemento </label>
      <input type="text" name="complemento" id="complemento" class="form-control" title="Endereço" value="{{$cartorio->complemento}}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <button type="button" class="btn btn-primary pull-right btn-form-info">Continuar</button>
  </div>
</div>
