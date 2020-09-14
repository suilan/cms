<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateCartorioBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartorio_bancos', function (Blueprint $table) {
            $table->unsignedInteger('cartorio_id');
            $table->unsignedInteger('banco_id')->nullable();
            $table->unsignedInteger('cidade_id')->nullable();
            $table->string('favorecido', 255)->nullable();
            $table->integer('tipo_favorecido')->nullable();
            $table->string('cpf_cnpj', 255)->nullable();
            $table->string('agencia', 255)->nullable();
            $table->string('conta_corrente', 255)->nullable();
            $table->string('conta_poupanca', 255)->nullable();
            $table->timestamps();
            $table->primary('cartorio_id');
            $table->index('cidade_id', 'cartorio_bancos_cidade_id_foreign');
            $table->index('banco_id', 'cartorio_bancos_banco_id_foreign');
            
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartorio_bancos');
    }
}