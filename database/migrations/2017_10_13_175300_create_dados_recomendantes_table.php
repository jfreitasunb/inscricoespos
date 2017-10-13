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
            $table->string('nome_recomendante',200);
            $table->string('instituicao_recomendante',500);
            $table->string('titulacao_recomendante',200);
            $table->string('area_recomendante',200);
            $table->integer('ano_titulacao');
            $table->string('inst_obtencao_titulo',500);
            $table->text('endereco_recomendante');
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
