<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscolhasCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escolhas_candidato', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->integer('programa_pretendido');
            $table->foreign('programa_pretendido')->references('programa')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->integer('area_pos')->default(0);
            $table->foreign('area_pos')->references('id_area_pos')->on('area_pos_mat')->onDelete('cascade');
            $table->boolean('interesse_bolsa');
            $table->boolean('vinculo_empregaticio');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
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
        Schema::drop('escolhas_candidato');
    }
}
