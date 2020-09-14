<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiler extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profile';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['cpfcnpj', 'nome', 'sobrenome', 'logradouro', 'bairro', 'cep', 'sexo', 'dtnascimento'];
}
