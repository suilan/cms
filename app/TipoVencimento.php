<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVencimento extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tipo_vencimentos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','nome'];

}
