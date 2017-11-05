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
            'data_nascimento' => '1979-05-28',
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
            'data_nascimento' => '1963-04-01',
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

        $configura_inscricao_pos = ['inicio_inscricao' => '2012-10-15', 'fim_inscricao' => '2012-11-01', 'prazo_carta' => '2012-11-05','edital' => '2012-2', 'programa' => '1_2', 'id_coordenador' => '2','created_at' => '2012-10-10 14:00:00', 'updated_at' => '2012-10-10 14:00:00'];

        $db_configura_inscricao_pos = DB::table('configura_inscricao_pos')->insert($configura_inscricao_pos);


        $lista_areas_pos = [1 => 'Álgebra', 2 => 'Análise', 3 => 'Análise Numérica', 4 => 'Geometria', 5 => 'Matemática Aplicada', 6 => 'Probabilidade', 7 => 'Sistemas Dinâmicos', 8 => 'Teoria da Computação', 9 => 'Teoria dos Números'];

        for ($i=1; $i < sizeof($lista_areas_pos)+1; $i++) { 
            
            $disciplina = ['id_area_pos' => $i, 'nome' => $lista_areas_pos[$i], 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
            $db_disciplina = DB::table('area_pos_mat')->insert($disciplina);
        }


        $programa_pos1 = ['id_programa_pos' => 1, 'tipo_programa_pos' => 'Mestrado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos1 = DB::table('programa_pos_mat')->insert($programa_pos1);

        $programa_pos2 = ['id_programa_pos' => 2, 'tipo_programa_pos' => 'Doutorado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos2 = DB::table('programa_pos_mat')->insert($programa_pos2);


        $programa_pos3 = ['id_programa_pos' => 3, 'tipo_programa_pos' => 'Verão', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos3 = DB::table('programa_pos_mat')->insert($programa_pos3);

        $formacao1 = ['id' => 1, 'tipo' => 'Bacharelado', 'nivel' => 'Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao1 = DB::table('formacao')->insert($formacao1);

        $formacao2 = ['id' => 2, 'tipo' => 'Licenciatura', 'nivel' => 'Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao2 = DB::table('formacao')->insert($formacao2);

        $formacao3 = ['id' => 3, 'tipo' => 'Ambos', 'nivel' => 'Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao3 = DB::table('formacao')->insert($formacao3);

        $formacao4 = ['id' => 4, 'tipo' => 'Não se Aplica', 'nivel' => 'Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao4 = DB::table('formacao')->insert($formacao4);

        $formacao5 = ['id' => 5, 'tipo' => 'Acadêmico', 'nivel' => 'Pós-Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao5 = DB::table('formacao')->insert($formacao5);

        $formacao6 = ['id' => 6, 'tipo' => 'Profissional', 'nivel' => 'Pós-Graduação', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_formacao6 = DB::table('formacao')->insert($formacao6);

        $this->call(PaisesTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(CidadesTableSeeder::class);

    }
}
