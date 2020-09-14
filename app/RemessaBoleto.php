<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemessaBoleto extends Model
{
	use SoftDeletes;

    protected $table = 'arquivo_remessa_boletos';
	protected $dates = ['deleted_at'];
}
