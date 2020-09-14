<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContato extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tipo_contatos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','nome'];

}
