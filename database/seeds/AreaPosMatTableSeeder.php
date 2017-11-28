<?php

use Illuminate\Database\Seeder;

class AreaPosMatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('area_pos_mat')->delete();
        
        \DB::table('area_pos_mat')->insert(array (
            0 => 
            array (
                'id_area_pos' => 1,
                'nome' => 'Álgebra',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id_area_pos' => 2,
                'nome' => 'Análise',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 => 
            array (
                'id_area_pos' => 3,
                'nome' => 'Análise Numérica',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 => 
            array (
                'id_area_pos' => 4,
                'nome' => 'Geometria',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 => 
            array (
                'id_area_pos' => 5,
                'nome' => 'Matemática Aplicada',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 => 
            array (
                'id_area_pos' => 6,
                'nome' => 'Probabilidade',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            6 => 
            array (
                'id_area_pos' => 7,
                'nome' => 'Sistemas Dinâmicos',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            7 => 
            array (
                'id_area_pos' => 8,
                'nome' => 'Teoria da Computação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            8 => 
            array (
                'id_area_pos' => 9,
                'nome' => 'Teoria dos Números',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));

        $tableToCheck = 'area_pos_mat';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id_area_pos)'))->first();
        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_area_pos_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_area_pos_seq\', '.$highestId->max.')');   
    }
}