<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosBancariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_bancarios', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_user');
            $table->string('nome_banco',100);
            $table->string('numero_banco',10);
            $table->string('agencia_bancaria',10);
            $table->string('numero_conta_corrente',10);
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
        Schema::drop('dados_bancarios');
    }
}
