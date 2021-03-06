<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateRemessasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remessas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arquivo', 255);
            $table->tinyInteger('cancelado');
            $table->timestamps();
            $table->unsignedInteger('cartorio_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('edital_id')->nullable();
            $table->index('cartorio_id', 'remessas_cartorio_id_foreign');
            $table->index('user_id', 'remessas_user_id_foreign');
            $table->index('edital_id', 'remessas_edital_id_foreign');
            
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
        Schema::dropIfExists('remessas');
    }
}
