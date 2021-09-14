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
            $table->increments('id_inicio_programa');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->integer('mes_inicio');
            $table->date('prazo_confirmacao');
            $table->unsignedInteger('id_coordenador');
            $table->foreign('id_coordenador')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('programa_para_confirmar')->nullable();
            $table->foreign('programa_para_confirmar')->references('id_programa_pos')->on('programa_pos_mat')->onDelete('cascade');
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
