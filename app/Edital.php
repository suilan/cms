<?php namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Edital extends Model {

	protected $table = 'editais';

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

	public function dataUtilSeconds()
	{
		// Próximo dia útil
		$daySeconds = 86400; 
		$nextDate = strtotime($this->created_at)+$daySeconds;
		if( $this->created_at ){
			$holiday = DB::table('feriados')->where('data','=',date('Y-m-d',$nextDate))->first();
			if($holiday) $nextDate =+ $daySeconds;

			$dayOfTheWeek = date('D',$nextDate);
			if( $dayOfTheWeek=='Sat') $nextDate=+ $daySeconds*2;
			if( $dayOfTheWeek=='Sun') $nextDate=+ $daySeconds;

			return $nextDate;
		}
	}
}
