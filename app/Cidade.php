<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model {

	protected $table = 'cidades';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nome','uf'];

	protected $hidden = ['estado_id','created_at','updated_at','status','ibge',];

	public function usuarios()
	{
		return $this->hasMany('App\User');
	}
}
