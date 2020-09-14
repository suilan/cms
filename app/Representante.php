<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Representante extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'representante';

	protected $hidden = ['id','user_id','motivo_descrendenciamento','cidade_id', 'creden', 'creden_img', 'contratosocial', 'cartaocnpj', 'procuracao', 'motivo_descredenciamento', 'created_at', 'updated_at'];

	public function representanteUser() {
		return $this->belongsTo('App\User');
	}

	public function cidades() {
		return $this->belongsTo('App\Cidade','cidade_id');
	}
}