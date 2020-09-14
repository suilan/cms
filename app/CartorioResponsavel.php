<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CartorioResponsavel extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cartorio_responsavels';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['cartorio_id','tipo_responsavel_id','nome','cpf','rg','endereco','numero','bairro','cep','tel','cel1','cel2','email'];

	public static function getResponsavel( $cartorioId, $responsavel)
	{
		return self::where('cartorio_id',$cartorioId)
			->select('cartorio_responsavels.*','cidades.nome as cidade','cidades.ibge as ibge')
			->leftJoin('cidades','cidades.id','=','cartorio_responsavels.cidade_id')
			->join('tipo_responsaveis','tipo_responsaveis.id','=','tipo_responsavel_id')
			->where('slug','=',$responsavel)
			->first();
	}
}
