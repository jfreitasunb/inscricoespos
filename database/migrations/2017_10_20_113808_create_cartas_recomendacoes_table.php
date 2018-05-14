<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartasRecomendacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartas_recomendacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_prof');
            $table->foreign('id_prof')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_aluno');
            $table->foreign('id_aluno')->references('id_user')->on('users')->onDelete('cascade');
            $table->integer('programa_pretendido');
            $table->unsignedInteger('id_inscricao_pos');
            $table->foreign('id_inscricao_pos')->references('id_inscricao_pos')->on('configura_inscricao_pos')->onDelete('cascade');
            $table->string('tempo_conhece_candidato',50)->nullable();
            $table->string('circunstancia_1', 10)->nullable();
            $table->string('circunstancia_2', 10)->nullable();
            $table->string('circunstancia_3', 10)->nullable();
            $table->string('circunstancia_4', 10)->nullable();
            $table->string('circunstancia_outra', 256)->nullable();
            $table->integer('desempenho_academico')->nullable();
            $table->integer('capacidade_aprender')->nullable();
            $table->integer('capacidade_trabalhar')->nullable();
            $table->integer('criatividade')->nullable();
            $table->integer('curiosidade')->nullable();
            $table->integer('esforco')->nullable();
            $table->integer('expressao_escrita')->nullable();
            $table->integer('expressao_oral')->nullable();
            $table->integer('relacionamento')->nullable();
            $table->text('antecedentes_academicos')->nullable();
            $table->text('possivel_aproveitamento')->nullable();
            $table->text('informacoes_relevantes')->nullable();
            $table->integer('como_aluno')->nullable();
            $table->integer('como_orientando')->nullable();
            $table->boolean('completada')->default(0);;
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
        Schema::dropIfExists('cartas_recomendacoes');
    }
}
