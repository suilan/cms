<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartorio extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cartorios';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','nome','cnpj','bairro','endereco','numero','cep','complemento','site','informatizado','empresainfo','contatoinfo','cidade_id'];

}
