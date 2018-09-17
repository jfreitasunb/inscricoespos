<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguraInicioProgramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configura_inicio_programa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->unsignedInteger('programa_pretendido');
            $table->foreign('programa_pretendido')->references('id_programa_pos')->on('programa_pos_mat')->onDelete('cascade');
            $table->boolean('selecionado');
            $table->boolean('confirmou_presenca')->default(False);
            $table->unsignedInteger('inicio_no_programa');
            $table->foreign('inicio_no_programa')->references('id_inicio_programa')->on('configura_inicio_programa')->onDelete('cascade');
            $table->unsignedInteger('id_coordenador');
            $table->foreign('id_coordenador')->references('id_user')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('configura_inicio_programa');
    }
}
