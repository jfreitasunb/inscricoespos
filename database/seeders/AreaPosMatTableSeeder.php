<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaPosMatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('area_pos_mat')->delete();

        \DB::table('area_pos_mat')->insert(array (
            0 =>
            array (
                'nome_ptbr' => 'Álgebra',
                'nome_en' => 'Algebra',
                'nome_es' => 'Álgebra',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 =>
            array (
                'nome_ptbr' => 'Análise',
                'nome_en' => 'Analysis',
                'nome_es' => 'Análisis',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 =>
            array (
                'nome_ptbr' => 'Análise Numérica',
                'nome_en' => 'Numerical Analysis',
                'nome_es' => 'Análisis Numérico',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 =>
            array (
                'nome_ptbr' => 'Dinâmica de Fluidos',
                'nome_en' => 'Fluid Dynamics',
                'nome_es' => 'Dinamica de Fluidos',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 =>
            array (
                'nome_ptbr' => 'Geometria',
                'nome_en' => 'Geometry',
                'nome_es' => 'Geometría',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 =>
            array (
                'nome_ptbr' => 'Probabilidade',
                'nome_en' => 'Probability',
                'nome_es' => 'Probabilidad ',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            6 =>
            array (
                'nome_ptbr' => 'Sistemas Dinâmicos',
                'nome_en' => 'Dynamical Systems',
                'nome_es' => 'Sistemas Dinámicos',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            7 =>
            array (
                'nome_ptbr' => 'Teoria da Computação',
                'nome_en' => 'Theory of Computation',
                'nome_es' => 'Teoría de la Computación',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            8 =>
            array (
                'nome_ptbr' => 'Teoria dos Números',
                'nome_en' => 'Number Theory',
                'nome_es' => 'Teoría de los Números',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            9 =>
            array (
                'nome_ptbr' => 'Não se Aplica',
                'nome_en' => 'Not applicable',
                'nome_es' => 'No se aplica',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));

        $tableToCheck = 'area_pos_mat';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id)'))->first();

        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_seq\', '.$highestId->max.')');
    }
}
