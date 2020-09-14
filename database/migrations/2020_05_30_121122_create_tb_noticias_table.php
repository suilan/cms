<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateTbNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsavel_id')->nullable();
            $table->string('titulo', 255)->nullable();
            $table->string('descricao', 255)->nullable();
            $table->integer('status')->nullable();
            $table->string('imagem', 255)->nullable();
            $table->string('imagem_url', 255)->nullable();
            $table->string('conteudo', 255)->nullable();
            $table->timestamps();

            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_noticias');
    }
}