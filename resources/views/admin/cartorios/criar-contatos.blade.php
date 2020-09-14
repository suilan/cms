<div class="row">
  <div class="col-xs-6">
    <div class="form-group">
      <label for="input" class="control-label">Site </label>
      <input type="text" name="site" id="site" class="form-control" value="{{$cartorio->site}}"  title="Site">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-6">
    <div class="form-group">
      <label for="input" class="control-label">E-mail*</label>
      <input type="hidden" name="contact[0][type]" class="type-input" value="3" />
      <input type="email" name="contact[0][number]" id="site" class="form-control" value="{{$contatos[0]->contato}}" title="E-mail">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-4">
    <label for="">Telefones*</label>
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
        <input type="hidden" name="contact[1][type]"value="1" />
        <input class="form-control telefone" name="contact[1][number]" placeholder="Telefone 1" type="text" value="{{$contatos[1]->contato}}">
      </div>
    </div>
  </div>
  <br>
</div>
<div class="row">
  <div class="col-xs-4">
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
        <input type="hidden" name="contact[2][type]" value="1" />
        <input class="form-control telefone" name="contact[2][number]" placeholder="Telefone 2" type="text" value="{{$contatos[2]->contato}}">
      </div>
    </div>
  </div>
  <br>
</div>
<div class="row">
  <div class="col-xs-4">
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
        <input type="hidden" name="contact[3][type]" value="2" />
        <input class="form-control celular" name="contact[3][number]" placeholder="Celular" type="text" value="{{isset($contatos[3])?$contatos[3]->contato:""}}">
      </div>
    </div>
  </div>
  <br>
</div>
<div class="row">
  <div class="col-xs-4">
    <div class="form-group">
      <div class="contact-list">
        <div class="input-group contact-input">
          <span class="input-group-btn">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="type-text">Tipo</span>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              @foreach($tipoContatos as $key => $value)
              <li>
                <a class="changeType" href="javascript:;" data-type-value="{{$value->id}}">
                  {{$value->nome}}
                </a>
              </li>
              @endforeach
            </ul>
          </span>
          <input type="hidden" name="contact[{{$totalContatos}}][type]" class="type-input" value="" />
          <input type="text" name="contact[{{$totalContatos}}][number]" class="form-control" />
        </div>
        @if( $totalContatos>4 )
            @for($i=4; $i<$totalContatos; $i++)
            <div class="input-group contact-input" style="margin-top:8px;">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="type-text">{{$contatos[$i]->tipo_contato}}</span>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  @foreach($tipoContatos as $key => $value)
                  <li>
                    <a class="changeType" href="javascript:;" data-type-value="{{$value->id}}">
                      {{$value->nome}}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </span>
              <input type="hidden" name="contact[{{$i}}][type]" class="type-input" value="{{$contatos[$i]->tipocontato_id}}" />
              <input type="text" name="contact[{{$i}}][number]" class="form-control" value="{{$contatos[$i]->contato}}"  />

              <span class="input-group-btn">
              <button class="btn btn-danger btn-remove-contact" type="button"><span class="glyphicon glyphicon-remove"></span></button>
              </span>
            </div>
            @endfor
        @endif
      </div>
    </div>
  </div>
  <div class="col-xs-2">
    <button id="btn-add-contact" type="button" class="btn btn-info  btn-add-contact">
      <span class="glyphicon glyphicon-plus"></span> Adicionar</button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <a href="#" class="btn btn-voltar">Voltar</a>
      <button type="button" class="btn btn-primary pull-right btn-form-contato">Continuar</button>
    </div>
  </div>
