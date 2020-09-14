<?php

use Illuminate\Database\Seeder;
use App\Cartorio;

class CartorioTableSeeder extends Seeder
{
	public function run()
	{
	DB::table('cartorios')->delete();
			    
	Cartorio::create(array(
		'id'            => '1',
		'nome'     		=> '1 Cartorio de Protestos do Maranhão',
	    'cnpj'     		=> '2313131515',
	    'bairro'   		=> 'Centro',
	    'endereco' 		=> 'Rua do Comboco',
	    'numero'   		=> '122',
	    'cep'      		=> '65000-000',
	    'site'     		=> 'http://protestoma.com.br',
	    'informatizado' => '1',
	    'cidade_id'     => '1314',
	));
	}
}