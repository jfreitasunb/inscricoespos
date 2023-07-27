<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosRecomendantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos_recomendantes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_recomendante');
            $table->foreign('id_recomendante')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->boolean('email_enviado')->default(false);
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
        Schema::dropIfExists('contatos_recomendantes');
    }
}
