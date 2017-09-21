<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosPessoaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_pessoais', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_user');
            $table->string('nome');
            $table->date('data_nascimento')->nullable();
            $table->string('numerorg',30)->nullable();
            $table->string('endereco',255)->nullable();
            $table->string('cep',11)->nullable();
            $table->integer('pais')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('cidade')->nullable();
            $table->string('celular',20)->nullable();
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
        Schema::drop('dados_pessoais');
    }
}
