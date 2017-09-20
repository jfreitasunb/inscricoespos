<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        

        $user = ['email' => 'jfreitas@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'admin' , 'ativo' => '1', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $user = ['email' => 'posgrad@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'coordenador' , 'ativo' => '1', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $dados_jota = [
            'id_user' => '1',
            'nome' => 'Jota',
            'numerorg' => '1',
            'endereco' => '1',
            'cidade' => '1',
            'cep' => '1',
            'estado' => '1',
            'celular' => '1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $db_dados_pessoais = DB::table('dados_pessoais')->insert($dados_jota);

        $dados_coord = [
            'id_user' => '2',
            'nome' => 'Coordenação de Pós-Graduação',
            'numerorg' => '2', 
            'endereco' => '2',
            'cidade' => '2',
            'cep' => '2',
            'estado' => '2',
            'celular' => '2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $db_dados_coord = DB::table('dados_pessoais')->insert($dados_coord);

        $configura_inscricao_pos = ['inicio_inscricao' => '2017-09-01', 'fim_inscricao' => '2017-09-30', 'prazo_carta' => '2017-10-01','edital' => '2017-1', 'programa' => '1_2', 'id_coordenador' => '2','created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_configura_inscricao_pos = DB::table('configura_inscricao_pos')->insert($configura_inscricao_pos);


        $lista_areas_pos = [1 => 'Álgebra', 2 => 'Análise', 3 => 'Geometria', 4 => 'Matemática Aplicada', 5 => 'Teoria dos Números', 6 => 'Sistemas Dinâmicos'];

        for ($i=1; $i < sizeof($lista_areas_pos)+1; $i++) { 
            
            $disciplina = ['id_area_pos' => $i, 'nome' => $lista_areas_pos[$i], 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
            $db_disciplina = DB::table('area_pos_mat')->insert($disciplina);
    }


        $programa_pos1 = ['id_programa_pos' => 1, 'tipo_programa_pos' => 'Mestrado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos1 = DB::table('programa_pos_mat')->insert($programa_pos1);

        $programa_pos2 = ['id_programa_pos' => 2, 'tipo_programa_pos' => 'Doutorado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos2 = DB::table('programa_pos_mat')->insert($programa_pos2);

        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

    }
}
