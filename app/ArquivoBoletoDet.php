<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ArquivoBoletoDet extends Model implements Auditable{
	use \OwenIt\Auditing\Auditable;

	protected $table = 'arquivo_remessa_boleto_dets';
}
