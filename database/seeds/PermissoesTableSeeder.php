<?php

use Illuminate\Database\Seeder;

class PermissoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissoes')->delete();
			   
		DB::table('permissoes')->insert([
            [ 'id' => 1,'pagina_id' => 1, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 2,'pagina_id' => 2, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 3,'pagina_id' => 3, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 4,'pagina_id' => 4, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 5,'pagina_id' => 5, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 6,'pagina_id' => 6, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 7,'pagina_id' => 7, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 8,'pagina_id' => 8, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 9,'pagina_id' => 9, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 10,'pagina_id' => 10, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 11,'pagina_id' => 11, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 12,'pagina_id' => 12, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 13,'pagina_id' => 13, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 14,'pagina_id' => 14, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 15,'pagina_id' => 15, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 16,'pagina_id' => 16, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 17,'pagina_id' => 17, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 18,'pagina_id' => 18, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 19,'pagina_id' => 19, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 26,'pagina_id' => 24, 'papel_id' => 1, 'ler' => 1, 'escrever' =>0],
            [ 'id' => 33,'pagina_id' => 25, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 44,'pagina_id' => 26, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 45,'pagina_id' => 27, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1],
            [ 'id' => 74,'pagina_id' => 31, 'papel_id' => 1, 'ler' => 1, 'escrever' =>1]
        ]);


    }
}
