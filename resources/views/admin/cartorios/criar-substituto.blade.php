<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">Nome </label>
            <input type="text" name="substitutoNome" id="substitutoNome" class="form-control" value="{{$substituto->nome}}" title="Nome">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">CPF </label>
            <input type="text" name="substitutoCPF" id="substitutoCPF" class="form-control cpf-mask" value="{{$substituto->cpf}}"   title="CPF">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">RG </label>
            <input type="text" name="substitutoRG" id="substitutoRG" class="form-control" value="{{$substituto->rg}}"   title="RG">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Telefone </label>
            <input type="text" name="substitutoTelefone" id="substitutoTelefone" class="form-control telefone" value="{{$substituto->tel}}"   title="Telefone">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Celular 1 </label>
            <input type="text" name="substitutoCelular1" id="substitutoCelular1" class="form-control celular" value="{{$substituto->cel1}}"   title="Celular 1">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Celular 2 </label>
            <input type="text" name="substitutoCelular2" id="substitutoCelular2" class="form-control celular" value="{{$substituto->cel2}}" title="Celular 2">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-9">
        <div class="form-group">
            <label for="input" class="control-label">E-mail </label>
            <input type="text" name="substitutoEmail" id="substitutoEmail" class="form-control" value="{{$substituto->email}}"   title="E-mail">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a href="#" class="btn btn-voltar">Voltar</a>
        <button type="button" class="btn btn-primary pull-right btn-form-substituto">Continuar</button>
    </div>
</div>
