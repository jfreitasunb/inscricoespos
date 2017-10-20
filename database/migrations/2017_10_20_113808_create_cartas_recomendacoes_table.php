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
            $table->integer('programa');
            $table->string('tempo_conhece_candidato',50)->nullable();
            $table->string('circunstancia_1', 10)->nullable();
            $table->string('circunstancia_2', 10)->nullable();
            $table->string('circunstancia_3', 10)->nullable();
            $table->string('circunstancia_4', 10)->nullable();
            $table->string('circunstancia_outra', 256)->nullable();
            $table->string('desempenho_academico', 7)->nullable();
            $table->string('capacidade_aprender', 7)->nullable();
            $table->string('capacidade_trabalhar', 7)->nullable();
            $table->string('criatividade', 7)->nullable();
            $table->string('curiosidade', 7)->nullable();
            $table->string('esforco', 7)->nullable();
            $table->string('expressao_escrita', 7)->nullable();
            $table->string('expressao_oral', 7)->nullable();
            $table->string('relacionamento', 7)->nullable();
            $table->text('antecedentes_academicos')->nullable();
            $table->text('possivel_aproveitamento')->nullable();
            $table->text('informacoes_relevantes')->nullable();
            $table->string('como_aluno', 7)->nullable();
            $table->string('como_orientando', 7)->nullable();
            $table->string('outra_situacao', 7)->nullable();
            $table->boolean('completa');
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
        Schema::dropIfExists('cartas_recomendacoes');
    }
}
