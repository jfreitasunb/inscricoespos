<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioEscolhidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_escolhido', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_user');
            $table->string('horario_monitoria',100);
            $table->string('dia_semana',100);
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
        Schema::drop('horario_escolhido');
    }
}
