<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {

	protected $table = 'estados';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id','codigouf','nome','uf','regiao','created_at','updated_at'
	];
}