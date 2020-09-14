<div class="row">
  <div class="col-sm-3">
    <div class="form-group">
      <label for="input" class="control-label">Nome </label>
      <input type="text" name="tabeliaoNome" id="tabeliaoNome" class="form-control" value="{{$tabeliao->nome}}" title="Nome">
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group">
      <label for="input" class="control-label">CPF </label>
      <input type="text" name="tabeliaoCPF" id="tabeliaoCPF" class="form-control cpf-mask" value="{{$tabeliao->cpf}}" title="CPF">
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group">
      <label for="input" class="control-label">RG </label>
      <input type="text" name="tabeliaoRG" id="tabeliaoRG" class="form-control" value="{{$tabeliao->rg}}" title="RG">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-3">
    <div class="form-group">
      <label for="input" class="control-label">Telefone </label>
      <input type="text" name="tabeliaoTelefone" id="tabeliaoTelefone" class="form-control telefone" value="{{$tabeliao->tel}}"   title="Telefone">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label for="input" class="control-label">Celular 1 </label>
      <input type="text" name="tabeliaoCelular1" id="tabeliaoCelular1" class="form-control celular" value="{{$tabeliao->cel1}}"   title="Celular 1">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label for="input" class="control-label">Celular 2 </label>
      <input type="text" name="tabeliaoCelular2" id="tabeliaoCelular2" class="form-control celular" value="{{$tabeliao->cel2}}" title="Celular 2">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-9">
    <div class="form-group">
      <label for="input" class="control-label">E-mail </label>
      <input type="text" name="tabeliaoEmail" id="tabeliaoEmail" class="form-control" value="{{$tabeliao->email}}"   title="E-mail">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <a href="#" class="btn btn-voltar">Voltar</a>
    <button type="button" class="btn btn-primary pull-right btn-form-tabeliao">Continuar</button>
  </div>
</div>
