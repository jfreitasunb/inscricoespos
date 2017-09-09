<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosAcademicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_academicos', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_user');
            $table->double('ira',2,5);
            $table->boolean('monitor_convidado')->nullable();
            $table->string('nome_professor',255)->nullable();
            $table->string('curso_graduacao',255);
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
        Schema::drop('dados_academicos');
    }
}
