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
            $table->integer('id_prof');
            $table->integer('id_aluno');
            $table->integer('programa_pretendido');
            $table->integer('id_inscricao_pos');
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
