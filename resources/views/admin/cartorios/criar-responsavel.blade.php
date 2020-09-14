<div class="row">
    <div class="col-sm-6">
        <div class="checkbox">
            <i class="fa fa-fw fa-info-circle" title="Enquanto esta opção estiver marcada, qualquer alteração feita nesta aba será ignorada."></i>
            Repetir dados da aba:
            <label for="responsavel-tabeliao">
                @if( $tabeliao->cpf && $tabeliao->cpf==$responsavel->cpf)
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-tabeliao" value="1" checked>
                @else
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-tabeliao" value="1">
                @endif
                Tabelião
            </label>
            <label for="responsavel-substituto">
                @if( $substituto->cpf && $substituto->cpf==$responsavel->cpf)
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-substituto" value="2" checked>
                @else
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-substituto" value="2">
                @endif
                Substituto
            </label>
            <label for="responsavel-unico">
                @if( $substituto->cpf!=$responsavel->cpf && $tabeliao->cpf!=$responsavel->cpf)
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-unico" value="0" checked>
                @else
                <input class="pull-left" type="radio" name="responsavel-fill" id="responsavel-unico" value="0">
                @endif
                Terceiros
            </label>
        </div>
    </div>
</div>
<div class="clear-fix" style="border-bottom:1px solid #D2DED6;"></div>
<br>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">Nome </label>
            <input type="text" name="responsavelNome" id="responsavelNome" class="form-control" value="{{$responsavel->nome}}" title="Nome">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">CPF </label>
            <input type="text" name="responsavelCPF" id="responsavelCPF" class="form-control cpf-mask" value="{{$responsavel->cpf}}"   title="CPF">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="input" class="control-label">RG </label>
            <input type="text" name="responsavelRG" id="responsavelRG" class="form-control" value="{{$responsavel->rg}}"   title="RG">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Telefone </label>
            <input type="text" name="responsavelTelefone" id="responsavelTelefone" class="form-control telefone" value="{{$responsavel->tel}}"  title="Telefone">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Celular 1 </label>
            <input type="text" name="responsavelCelular1" id="responsavelCelular1" class="form-control celular" value="{{$responsavel->cel1}}"  title="Celular 1">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="input" class="control-label">Celular 2 </label>
            <input type="text" name="responsavelCelular2" id="responsavelCelular2" class="form-control celular" value="{{$responsavel->cel2}}" title="Celular 2">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-9">
        <div class="form-group">
            <label for="input" class="control-label">E-mail </label>
            <input type="text" name="responsavelEmail" id="responsavelEmail" class="form-control" value="{{$responsavel->email}}"  title="E-mail">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a href="#" class="btn btn-voltar">Voltar</a>
        <button type="button" class="btn btn-primary pull-right btn-form-responsavel">Continuar</button>
    </div>
</div>
