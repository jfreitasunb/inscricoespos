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
                'tipo_programa_pos' => 'Mestrado',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id_programa_pos' => 2,
                'tipo_programa_pos' => 'Doutorado',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 => 
            array (
                'id_programa_pos' => 3,
                'tipo_programa_pos' => 'Verão',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));
        
        
    }
}