<?php

use Illuminate\Database\Seeder;

class PaginasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('paginas')->delete();
			   
		DB::table('paginas')->insert([
            [ 'id' => 1, 'nome' => 'Home', 'caminho' => '', 'pai' =>'', 'status'=>1, 'ordem'=>1, 'admin'=>0, 'icon'=>''],
            [ 'id' => 2, 'nome' => 'Legislação', 'caminho' => 'links-uteis/legislacao', 'pai' =>'', 'status'=>1, 'ordem'=>2, 'admin'=>0, 'icon'=>''],
            [ 'id' => 3, 'nome' => 'Downloads', 'caminho' => 'links-uteis/downloads', 'pai' =>'', 'status'=>1, 'ordem'=>3, 'admin'=>0, 'icon'=>''],
            ['id' => 4, 'nome' => 'Sobre o Protesto', 'caminho' => 'protesto/sobre-o-protesto','pai'=>'', 'status'=> 1, 'ordem'=>4, 'admin'=>0, 'icon'=>''],
            ['id' => 5, 'nome' => 'Perguntas Frequentes', 'caminho' => 'protesto/faq','pai'=>'', 'status'=> 1, 'ordem'=>5, 'admin'=>0, 'icon'=>''],
            ['id' => 6, 'nome' => 'Eventos', 'caminho' => 'eventos', 'pai' =>'', 'status'=> 1, 'ordem'=>6, 'admin'=>0, 'icon'=>''],
            ['id' => 7, 'nome' => 'Quem Somos', 'caminho' => 'quem-somos', 'pai' =>'', 'status'=> 1, 'ordem'=>7, 'admin'=>0, 'icon'=>''],
            ['id' => 8, 'nome' => 'Contato', 'caminho' => 'contato', 'pai' =>'', 'status'=> 1, 'ordem'=>8, 'admin'=>0, 'icon'=>''],
            ['id' => 9, 'nome' => 'Monitoramento', 'caminho' => 'monitoramento', 'pai' =>'', 'status'=> 0, 'ordem'=>9, 'admin'=>0, 'icon'=>''],
            ['id' => 10, 'nome' => 'Imagens do Carousel', 'caminho' => 'admin/carousel', 'pai' =>'', 'status'=> 1, 'ordem'=>1, 'admin'=>1, 'icon'=>'home'],
            ['id' => 11, 'nome' => 'Notícias', 'caminho' => 'admin/noticias', 'pai' =>'Home', 'status'=> 1, 'ordem'=>2, 'admin'=>1, 'icon'=>'newspaper-o'],
            ['id' => 12, 'nome' => 'Eventos', 'caminho' => 'admin/eventos', 'pai' =>'Eventos', 'status'=> 1, 'ordem'=>3, 'admin'=>1, 'icon'=>'calendar'],
            ['id' => 13, 'nome' => 'Downloads', 'caminho' => 'admin/downloads', 'pai' =>'', 'status'=> 1, 'ordem'=>4, 'admin'=>1, 'icon'=>'download'],
            ['id' => 14, 'nome' => 'Tipo de Contatos', 'caminho' => 'admin/tipocontatos', 'pai' =>'Cartórios', 'status'=> 1, 'ordem'=>5, 'admin'=>1, 'icon'=>'book'],
            ['id' => 15, 'nome' => 'Cartórios', 'caminho' => 'admin/cartorios', 'pai' =>'Cartórios', 'status'=> 1, 'ordem'=>5, 'admin'=>1, 'icon'=>'book'],
            ['id' => 16, 'nome' => 'Contatos', 'caminho' => 'admin/contatos', 'pai' =>'', 'status'=> 1, 'ordem'=>6, 'admin'=>1, 'icon'=>'envelope'],
            ['id' => 17, 'nome' => 'Usuários', 'caminho' => 'admin/usuarios', 'pai' =>'Controle de Acesso', 'status'=> 1, 'ordem'=>8, 'admin'=>1, 'icon'=>'database'],
            ['id' => 18, 'nome' => 'Perfis de Acessos', 'caminho' => 'admin/perfil', 'pai' =>'Controle de Acesso', 'status'=> 1, 'ordem'=>8, 'admin'=>1, 'icon'=>'database'],
            ['id' => 19, 'nome' => 'Editais', 'caminho' => 'admin/editais', 'pai' =>'', 'status'=> 0, 'ordem'=>9, 'admin'=>1, 'icon'=>'calendar-check-o'],
            ['id' => 20, 'nome' => 'Remessas', 'caminho' => 'admin/remessas', 'pai' =>'Remessas', 'status'=> 1, 'ordem'=>10, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 21, 'nome' => 'Títulos', 'caminho' => 'admin/titulos', 'pai' =>'Remessas', 'status'=> 1, 'ordem'=>10, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 22, 'nome' => 'Endossos', 'caminho' => 'admin/endossos', 'pai' =>'Remessas', 'status'=> 1, 'ordem'=>10, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 23, 'nome' => 'Especies', 'caminho' => 'admin/especies', 'pai' =>'Remessas', 'status'=> 1, 'ordem'=>10, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 24, 'nome' => 'Galeria de imagens', 'caminho' => 'admin/galeria', 'pai' =>'', 'status'=> 1, 'ordem'=>11, 'admin'=>1, 'icon'=>'newspaper-o'],
            ['id' => 25, 'nome' => 'Legislação', 'caminho' => 'admin/legislacoes', 'pai' =>'', 'status'=> 1, 'ordem'=>7, 'admin'=>1, 'icon'=>'book'],
            ['id' => 26, 'nome' => 'Participantes', 'caminho' => 'admin/eventosinscritos', 'pai' =>'Eventos', 'status'=> 1, 'ordem'=>3, 'admin'=>1, 'icon'=>'calendar'],
            ['id' => 27, 'nome' => 'Credenciamento', 'caminho' => 'admin/credenciamento', 'pai' =>'Eventos', 'status'=> 1, 'ordem'=>3, 'admin'=>1, 'icon'=>'calendar'],
            ['id' => 29, 'nome' => 'Consulta Intimação', 'caminho' => 'admin/segundavia', 'pai' =>'Consulta', 'status'=> 1, 'ordem'=>13, 'admin'=>1, 'icon'=>'exclamation-circle'],
            ['id' => 30, 'nome' => 'Credenciamento PF', 'caminho' => 'admin/credenciamentoboleto', 'pai' =>'Consulta', 'status'=> 1, 'ordem'=>13, 'admin'=>1, 'icon'=>'exclamation-circle'],
            ['id' => 31, 'nome' => 'Totem', 'caminho' => 'admin/totem', 'pai' =>'Estatísticas', 'status'=> 1, 'ordem'=>14, 'admin'=>1, 'icon'=>'line-chart'],
            ['id' => 32, 'nome' => 'Consulta Intimação PJ', 'caminho' => 'admin/representante', 'pai' =>'Consulta', 'status'=> 1, 'ordem'=>13, 'admin'=>1, 'icon'=>'exclamation-circle'],
            ['id' => 33, 'nome' => 'Remessas de Boleto', 'caminho' => 'admin/remessaboleto', 'pai' =>'Consulta', 'status'=> 1, 'ordem'=>13, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 34, 'nome' => 'Credenciamento PJ', 'caminho' => 'admin/credenciamentorepresentante', 'pai' =>'Consulta', 'status'=> 1, 'ordem'=>13, 'admin'=>1, 'icon'=>'institution'],
            ['id' => 35, 'nome' => 'Devedores', 'caminho' => 'admin/devedores', 'pai' =>'Intimação Eletrônica', 'status'=> 1, 'ordem'=>14, 'admin'=>1, 'icon'=>'crosshairs']
        ]);

    }
}
