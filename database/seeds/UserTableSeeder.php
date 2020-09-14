<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();
			   
		DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'test@email.com',
			'password' => Hash::make('adm'),
			'verified' =>1,
			'cartorio_id'=>1,
			'papel_id'=>1
        ]);
	}
}