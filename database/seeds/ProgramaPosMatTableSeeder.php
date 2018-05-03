<?php

use Illuminate\Database\Seeder;

class ProgramaPosMatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('programa_pos_mat')->delete();
        
        \DB::table('programa_pos_mat')->insert(array (
            0 => 
            array (
                'id_programa_pos' => 1,
                'tipo_programa_pos_ptbr' => 'Mestrado',
                'tipo_programa_pos_en' => 'Master\'s degree',
                'tipo_programa_pos_es' => 'Maestría',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id_programa_pos' => 2,
                'tipo_programa_pos_ptbr' => 'Doutorado',
                'tipo_programa_pos_en' => 'PhD degree',
                'tipo_programa_pos_es' => 'Doctorado',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            // 2 => 
            // array (
            //     'id_programa_pos' => 3,
            //     'tipo_programa_pos' => 'Verão',
            //     'created_at' => '2017-11-21 15:27:00',
            //     'updated_at' => '2017-11-21 15:27:00',
            // ),
        ));
        
        $tableToCheck = 'programa_pos_mat';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id_programa_pos)'))->first();
        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_programa_pos_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_programa_pos_seq\', '.$highestId->max.')');
        
    }
}