<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguraInscricaoPosTable extends Migration
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
            $table->date('inicio_inscricao');
            $table->date('fim_inscricao');
            $table->date('prazo_carta');
            $table->string('programa',7);
            $table->string('edital',7);
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