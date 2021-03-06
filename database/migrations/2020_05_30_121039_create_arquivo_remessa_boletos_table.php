<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateArquivoRemessaBoletosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_remessa_boletos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cartorio_id')->nullable();
            $table->string('nome_arquivo', 200)->nullable();
            $table->string('data_remessa', 10)->nullable();
            $table->string('nome_cartorio', 200)->nullable();
            $table->string('cnpj_cartorio', 14)->nullable();
            $table->string('endereco_cartorio', 200)->nullable();
            $table->string('telefone_cartorio', 20)->nullable();
            $table->string('banco_conveniado_cobranca', 3)->nullable();
            $table->string('nome_banco_conveniado', 200)->nullable();
            $table->string('quantidade_titulo_remessa', 4)->nullable();
            $table->string('data_movimento', 10)->nullable();
            $table->string('quantidade_remessa', 4)->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('cartorio_id', 'arquivo_remessa_boletos_FK');
            
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
        Schema::dropIfExists('arquivo_remessa_boletos');
    }
}
