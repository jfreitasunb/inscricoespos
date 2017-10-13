<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosRecomendantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_recomendantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prof');
            $table->string('nome_recomendante',200)->nullable();
            $table->string('instituicao_recomendante',500)->nullable();
            $table->string('titulacao_recomendante',200)->nullable();
            $table->string('area_recomendante',200)->nullable();
            $table->integer('ano_titulacao')->nullable();
            $table->string('inst_obtencao_titulo',500)->nullable();
            $table->text('endereco_recomendante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_recomendantes');
    }
}
