<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('formacao')->delete();

        \DB::table('formacao')->insert(array (
            0 =>
            array (
                'tipo_ptbr' => 'Bacharelado',
                'tipo_en' => 'Bachelor’s degree',
                'tipo_es' => 'Bachillerato',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 =>
            array (
                'tipo_ptbr' => 'Licenciatura',
                'tipo_en' => 'College degree',
                'tipo_es' => 'Licenciatura',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 =>
            array (
                'tipo_ptbr' => 'Ambos',
                'tipo_en' => 'Both',
                'tipo_es' => 'Ambos',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 =>
            array (
                'tipo_ptbr' => 'Não se Aplica',
                'tipo_en' => 'Not applicable',
                'tipo_es' => 'No se aplica',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 =>
            array (
                'tipo_ptbr' => 'Mestrado Acadêmico',
                'tipo_en' => 'Master’s degree',
                'tipo_es' => 'Magíster',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 =>
            array (
                'tipo_ptbr' => 'Mestrado Profissional',
                'tipo_en' => null,
                'tipo_es' => null,
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            6 =>
            array (
                'tipo_ptbr' => 'Doutorado',
                'tipo_en' => 'PhD',
                'tipo_es' => 'Doctorado',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            7 =>
            array (
                'tipo_ptbr' => 'Especialização',
                'tipo_en' => null,
                'tipo_es' => null,
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            8 =>
            array (
                'tipo_ptbr' => 'Não se Aplica',
                'tipo_en' => 'Not applicable',
                'tipo_es' => 'No se aplica',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));

        $tableToCheck = 'formacao';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id)'))->first();

        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_seq\', '.$highestId->max.')');
    }
}
