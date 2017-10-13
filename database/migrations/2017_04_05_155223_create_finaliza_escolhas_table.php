<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalizaEscolhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finaliza_escolhas', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_user');
            $table->boolean('concorda_termos');
            $table->integer('id_inscricao_pos');
            $table->boolean('finalizar');
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
        Schema::drop('finaliza_escolhas');
    }
}
