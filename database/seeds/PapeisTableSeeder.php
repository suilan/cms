<?php

use Illuminate\Database\Seeder;

class PapeisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('papeis')->delete();
			   
		DB::table('papeis')->insert([
            'id' => 1,
            'nome' => 'super',
			'descricao' => 'Todos os acessos',
			'status' =>1
        ]);
    }
}
