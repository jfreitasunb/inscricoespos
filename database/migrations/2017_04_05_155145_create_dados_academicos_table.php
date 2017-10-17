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
            $table->string('curso_graduacao',255)->nullable();
            $table->integer('tipo_curso_graduacao')->nullable();
            $table->string('instituicao_graduacao',255)->nullable();
            $table->integer('ano_conclusao_graduacao')->nullable();
            $table->integer('tipo_curso_pos')->nullable();
            $table->string('instituicao_pos',255)->nullable();
            $table->integer('ano_conclusao_pos')->nullable();
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
