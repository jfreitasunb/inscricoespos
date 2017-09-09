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
            $table->string('escolha_aluno',20);
            $table->string('mencao_aluno',2);
            $table->integer('id_monitoria');
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
