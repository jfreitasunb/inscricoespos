<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguraMonitoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configura_monitoria', function (Blueprint $table){
            $table->increments('id_monitoria');
            $table->string('ano_monitoria',4);
            $table->string('semestre_monitoria',2);
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
        Schema::drop('configura_monitoria');
    }
}
