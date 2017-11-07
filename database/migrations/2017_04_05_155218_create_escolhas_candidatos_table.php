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
            $table->integer('id_user');
            $table->integer('programa_pretendido');
            $table->integer('area_pos')->default(0);
            $table->boolean('interesse_bolsa');
            $table->boolean('vinculo_empregaticio');
            $table->integer('id_inscricao_pos');
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
