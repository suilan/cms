<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model {

	protected $table = 'contatos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['contato','cartorio_id','tipocontato_id'];


}
