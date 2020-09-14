<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Devedor extends Model {

	use Notifiable;

	protected $table = 'devedores';

	public function routeNotificationForWhatsApp() {
		return "+55".str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$this->celular))));
	}
}
