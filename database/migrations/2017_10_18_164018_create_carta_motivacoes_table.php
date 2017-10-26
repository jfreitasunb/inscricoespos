<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartaMotivacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carta_motivacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->text('motivacao');
            $table->boolean('concorda_termos');
            $table->integer('id_inscricao_pos');
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
        Schema::dropIfExists('carta_motivacoes');
    }
}
