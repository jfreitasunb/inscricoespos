<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomologaInscricoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homologa_inscricoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->unsignedInteger('programa_pretendido');
            $table->foreign('programa_pretendido')->references('id_programa_pos')->on('programa_pos_mat')->onDelete('cascade');
            $table->boolean('homologada');
            $table->unsignedInteger('id_coordenador');
            $table->foreign('id_coordenador')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('homologa_inscricoes');
    }
}
