<?php

use Illuminate\Database\Seeder;

class FormacaoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('formacao')->delete();
        
        \DB::table('formacao')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tipo' => 'Bacharelado',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id' => 2,
                'tipo' => 'Licenciatura',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 => 
            array (
                'id' => 3,
                'tipo' => 'Ambos',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 => 
            array (
                'id' => 4,
                'tipo' => 'Não se Aplica',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 => 
            array (
                'id' => 5,
                'tipo' => 'Acadêmico',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 => 
            array (
                'id' => 6,
                'tipo' => 'Profissional',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));
        
        
    }
}