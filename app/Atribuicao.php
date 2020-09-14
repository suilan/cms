<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atribuicao extends Model {

	protected $table = 'atribuicoes';
	
	protected $fillable = ['cartorio_id','tipoatribuicao_id'];

}
