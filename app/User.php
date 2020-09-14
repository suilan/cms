<?php namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use OwenIt\Auditing\Contracts\Auditable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, Auditable {

	use Authenticatable, CanResetPassword;
	use SoftDeletes;
	use Notifiable;
	use \OwenIt\Auditing\Auditable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $hidden = ['id','password', 'remember_token','motivo_descrendenciamento','creden','cidade_id','papel_id','cartorio_id','verified','created_at','updated_at','deleted_at','token_notificacao', 'cidade','creden_image','celular_verificado_at'];

	protected $dates = ['deleted_at'];

	public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
	}
	
	public function representantes()
	{
		return $this->hasMany('App\Representante');
	}

	public function cidades() {
		return $this->belongsTo('App\Cidade','cidade_id');
	}

	public function routeNotificationForWhatsApp() {
		return "+55".str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$this->celular1))));
	}
}