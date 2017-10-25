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
            $table->string('desempenho_academico', 12)->nullable();
            $table->string('capacidade_aprender', 12)->nullable();
            $table->string('capacidade_trabalhar', 12)->nullable();
            $table->string('criatividade', 12)->nullable();
            $table->string('curiosidade', 12)->nullable();
            $table->string('esforco', 12)->nullable();
            $table->string('expressao_escrita', 12)->nullable();
            $table->string('expressao_oral', 12)->nullable();
            $table->string('relacionamento', 12)->nullable();
            $table->text('antecedentes_academicos')->nullable();
            $table->text('possivel_aproveitamento')->nullable();
            $table->text('informacoes_relevantes')->nullable();
            $table->string('como_aluno', 12)->nullable();
            $table->string('como_orientando', 12)->nullable();
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
