<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivosEnviadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos_enviados', function (Blueprint $table){
            $table->Increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id')->on('users')->onDelete('cascade');
            $table->string('nome_arquivo',255);
            $table->string('tipo_arquivo',50);
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->timestamps();
            $table->boolean('removido')->default(FALSE);
            $table->timestamp('data_remocao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('arquivos_enviados');
    }
}
