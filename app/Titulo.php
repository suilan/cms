<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model {

	protected $table = 'titulos';

	public static function dataBr($data)
	{
		if( $data )
		{
			$aux = explode('-',$data);
        	return $aux[2].'/'.$aux[1].'/'.$aux[0];
		}
		else return "";
	}

	public static function dataDB($data)
	{
		if( $data )
		{
			$aux = explode('/',$data);
        	return $aux[2].'-'.$aux[1].'-'.$aux[0];
		}
		else return "";
	}
}
