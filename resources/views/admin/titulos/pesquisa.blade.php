<input type="text" name="protocolo" value="{{Input::get('protocolo')}}" placeholder="Protocolo" class="form-control pull-left" style="width:8%;margin:0 5px 0 0;">
@if( $isAdmin)
<select name="cartorio" class="form-control pull-left" style="width:16%;margin:0 5px 0 0;">
    <option style="color:#000;" value="">-- Cartorios --</option>
    @foreach($cartorios as $k=>$c)
        <option style="color:#000;" value="{{$k}}" {{$cartorio_id==$k?'selected':''}} >{{$c}}</option>
    @endforeach
</select>
@endif
<input type="text" name="remessa" value="{{Input::get('remessa')}}" placeholder="Remessa" class="form-control pull-left" style="width:8%;margin:0 5px 0 0;">
<style type="text/css">.input-group-addon.selected{background-color:#3c8dbc;color:#fff;}</style>
<div class="input-group pull-left" style="width:23%;margin:0 5px 0 0;">
    <div class="input-group-addon ident cpf selected" style="font-size:12px;">CPF</div>
    <div class="input-group-addon ident cnpj" style="font-size:12px;">CNPJ</div>
    <input type="hidden" name="tipo_doc" id="tipo_doc" value="cpf">
    <input type="text" name="documento" id="documento" value="{{Input::get('documento')}}"" placeholder="Documento" class="form-control pull-left" >
</div>
<input type="text" name="devedor" value="{{Input::get('devedor')}}" placeholder="Devedor" class="form-control pull-left" style="width:18%;margin:0 5px 0 0;">
<div class="input-group date pull-left" style="width:13%;margin:0 5px 0 0;">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" name="emissao" id="datepicker" value="{{Input::get('emissao')}}"  placeholder="D. Emissão" class="form-control pull-left" >
</div>
<input type="text" name="saldo" id="saldo" placeholder="Saldo" value="{{Input::get('saldo')}}" class="form-control pull-left" style="width:7%;margin:0 5px 0 0;">
<button class="btn btn-success pull-left" name="pesquisa" value="1" title="Pesquisar"><i class="fa fa-search"></i></button>