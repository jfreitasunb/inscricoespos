<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class CartaRecomendacao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'cartas_recomendacoes';

    protected $fillable = [
        'tempo_conhece_candidato',
        'circunstancia_1',
        'circunstancia_2',
        'circunstancia_3',
        'circunstancia_4',
        'circunstancia_outra',
        'desempenho_academico',
        'capacidade_aprender',
        'capacidade_trabalhar',
        'criatividade',
        'curiosidade',
        'esforco',
        'expressao_escrita',
        'expressao_oral',
        'relacionamento',
        'antecedentes_academicos',
        'possivel_aproveitamento',
        'informacoes_relevantes',
        'como_aluno',
        'como_orientando',
        'outra_situacao',
    ];
}
