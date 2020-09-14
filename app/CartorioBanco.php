<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CartorioBanco extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cartorio_bancos';
	protected $primaryKey  = 'cartorio_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['cartorio_id','banco_id','cidade_id','favorecido','cpf_cnpj','agencia','conta_corrente','conta_poupanca','tipo_favorecido'];

}
