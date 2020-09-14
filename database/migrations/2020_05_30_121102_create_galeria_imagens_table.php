<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateGaleriaImagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeria_imagens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('albuns_id');
            $table->string('arquivo', 95)->nullable();
            $table->string('descricao', 125)->nullable();
            $table->timestamps();
            // $table->primary(['id', 'albuns_id']);
            $table->index('albuns_id', 'fk_galeria_img_idx');
            
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
        Schema::dropIfExists('galeria_imagens');
    }
}
