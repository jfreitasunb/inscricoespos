<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguraInscricaoPosPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configura_inscricao_pos', function (Blueprint $table){
            $table->increments('id_inscricao_pos');
            $table->string('ano_inscricao_pos',4);
            $table->string('semestre_inscricao_pos',2);
            $table->string('edital',6);
            $table->date('inicio_inscricao');
            $table->date('fim_inscricao');
            $table->integer('id_coordenador');
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
        Schema::drop('configura_inscricao_pos');
    }
}
