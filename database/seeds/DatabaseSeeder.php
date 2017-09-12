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
        // Estados
        $this->call('EstadosTableSeeder');

        // Cidades
        $this->call('CidadesAcreSeeder');
        $this->call('CidadesAlagoasSeeder');
        $this->call('CidadesAmapaSeeder');
        $this->call('CidadesAmazonasSeeder');
        $this->call('CidadesBahiaSeeder');
        $this->call('CidadesCearaSeeder');
        $this->call('CidadesDistritoFederalSeeder');
        $this->call('CidadesEspiritoSantoSeeder');
        $this->call('CidadesGoiasSeeder');
        $this->call('CidadesMaranhaoSeeder');
        $this->call('CidadesMatoGrossoSeeder');
        $this->call('CidadesMatoGrossoDoSulSeeder');
        $this->call('CidadesMinasGeraisSeeder');
        $this->call('CidadesParaSeeder');
        $this->call('CidadesParaibaSeeder');
        $this->call('CidadesParanaSeeder');
        $this->call('CidadesPernambucoSeeder');
        $this->call('CidadesPiauiSeeder');
        $this->call('CidadesRioDeJaneiroSeeder');
        $this->call('CidadesRioGrandeDoNorteSeeder');
        $this->call('CidadesRioGrandeDoSulSeeder');
        $this->call('CidadesRondoniaSeeder');
        $this->call('CidadesRoraimaSeeder');
        $this->call('CidadesSantaCatarinaSeeder');
        $this->call('CidadesSaoPauloSeeder');
        $this->call('CidadesSergipeSeeder');
        $this->call('CidadesTocantinsSeeder');
        
        $user = ['login' => 'javx', 'email' => 'jfreitas@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'admin' , 'ativo' => '1', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $user = ['login' => 'coordpos', 'email' => 'posgrad@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'coordenador' , 'ativo' => '1', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $dados_jota = [
            'id_user' => '1',
            'nome' => 'Jota',
            'numerorg' => '1',
            'emissorrg' => '1', 
            'cpf' => '1',
            'endereco' => '1',
            'cidade' => '1',
            'cep' => '1',
            'estado' => '1',
            'telefone' => '1',
            'celular' => '1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $db_dados_pessoais = DB::table('dados_pessoais')->insert($dados_jota);

        $dados_coord = [
            'id_user' => '2',
            'nome' => 'Coordenação de Pós-Graduação',
            'numerorg' => '2',
            'emissorrg' => '2', 
            'cpf' => '2',
            'endereco' => '2',
            'cidade' => '2',
            'cep' => '2',
            'estado' => '2',
            'telefone' => '2',
            'celular' => '2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $db_dados_coord = DB::table('dados_pessoais')->insert($dados_coord);

        $configura_inscricao_pos = ['ano_inscricao_pos' => '2018','semestre_inscricao_pos' => '1', 'edital' => '1-2017', 'inicio_inscricao' => '2017-09-01', 'fim_inscricao' => '2017-09-30', 'id_coordenador' => '2','created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_configura_inscricao_pos = DB::table('configura_inscricao_pos')->insert($configura_inscricao_pos);


        $lista_areas_pos = [1 => 'Álgebra', 2 => 'Análise', 3 => 'Geometria', 4 => 'Matemática Aplicada', 5 => 'Teoria dos Números', 6 => 'Sistemas Dinâmicos'];

        for ($i=1; $i < sizeof($lista_areas_pos)+1; $i++) { 
            
            $disciplina = ['id_area_pos' => $i, 'nome_curso' => $lista_areas_pos[$i], 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
            $db_disciplina = DB::table('cursos_graduacao')->insert($disciplina);
        }


        $programa_pos1 = ['id_programa_pos' => 1, 'nome' => 'Mestrado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos1 = DB::table('disciplinas_mat')->insert($programa_pos1);

        $programa_pos1 = ['id_programa_pos' => 2, 'nome' => 'Doutorado', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_programa_pos2 = DB::table('disciplinas_mat')->insert($programa_pos2);

        $d3 = ['codigo' => 113263, 'nome' => 'Topologia dos Espaços Métricos', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d3);

        $d4 = ['codigo' => 117145, 'nome' => 'Álgebra 3', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d4);

        $d5 = ['codigo' => 113123, 'nome' => 'Álgebra Linear', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d5);


        $d6 = ['codigo' => 113611, 'nome' => 'Álgebra para Ensino 1 e 2', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d6);

        $d7 = ['codigo' => 113212, 'nome' => 'Análise 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d7);

        $d8 = ['codigo' => 117137, 'nome' => 'Análise 3', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d8);

        $d9 = ['codigo' => 117137, 'nome' => 'Análise Combinatória', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d9);

        $d10 = ['codigo' => 113506, 'nome' => 'Análise Numérica 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d10);


        $d10 = ['codigo' => 113034, 'nome' => 'Cálculo 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d10);

        $d11 = ['codigo' => 113042, 'nome' => 'Cálculo 2', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d11);

        $d12 = ['codigo' => 113051, 'nome' => 'Cálculo 3', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d12);

        $d13 = ['codigo' => 113824, 'nome' => 'Cálculo de Probabilidade 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d13);

        $d14 = ['codigo' => 113832, 'nome' => 'Cálculo de Probabilidade 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        
        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d14);

        $d15 = ['codigo' => 113417, 'nome' => 'Cálculo Numérico', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d15);

        $d16 = ['codigo' => 113301, 'nome' => 'Equações Diferenciais 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d16);

        $d17 = ['codigo' => 113808, 'nome' => 'Fundamentos de Matemática 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d17);

        $d18 = ['codigo' => 117161, 'nome' => 'Geometria 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d18);

        $d19 = ['codigo' => 117170, 'nome' => 'Geometria 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d19);

        $d20 = ['codigo' => 113328, 'nome' => 'Geometria Diferencial 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d20);

        $d21 = ['codigo' => 117471, 'nome' => 'Geometria para o Ensino 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d21);

        $d22 = ['codigo' => 117480, 'nome' => 'Geometria para o Ensino 2', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d22);

        $d23 = ['codigo' => 113522, 'nome' => 'Métodos Matemáticos da Física 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d23);

        $d24 = ['codigo' => 113069, 'nome' => 'Variável Complexa 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d24);

        $d25 = ['codigo' => 117421, 'nome' => 'Álgebra para o Ensino 1', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d25);

        $d26 = ['codigo' => 117501, 'nome' => 'Álgebra para o Ensino 2', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d26);

        $d27 = ['codigo' => 117412, 'nome' => 'Introdução à Teoria da Metida e Integração', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d27);

        $d28 = ['codigo' => 113093, 'nome' => 'Introdução à Álgebra Linear', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d28);

        $d29 = ['codigo' => 117358, 'nome' => 'Lógica Matemática e Computacional', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d29);

        $d30 = ['codigo' => 117102, 'nome' => 'Métodos Matemáticos da Física 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d30);

        $d31 = ['codigo' => 113107, 'nome' => 'Álgebra 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d31);

        $d32 = ['codigo' => 113131, 'nome' => 'Álgebra 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d32);

        $d33 = ['codigo' => 113204, 'nome' => 'Análise 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d33);

        $d34 = ['codigo' => 105881, 'nome' => 'Geometria Analítica para Matemática', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d34);

        $d35 = ['codigo' => 113701, 'nome' => 'Introdução à Matemática Superior', 'creditos' => 6, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d35);

        $d37 = ['codigo' => 113018, 'nome' => 'Matemática 1', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d37);

        $d38 = ['codigo' => 113026, 'nome' => 'Matemática 2', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d38);

        $d39 = ['codigo' => 117510, 'nome' => 'Regência 1', 'creditos' => 8, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d39);

        $d40 = ['codigo' => 117439, 'nome' => 'Regência 2', 'creditos' => 8, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d40);

        $d41 = ['codigo' => 113859, 'nome' => 'Análise de Algorítmos', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d41);

        $d42 = ['codigo' => 113603, 'nome' => 'História da Matemática', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d42);

        $d43 = ['codigo' => 113930, 'nome' => 'Introdução à Teoria dos Grafos', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d43);

        $d44 = ['codigo' => 117307, 'nome' => 'Seminário de Tópicos em Matemática Aplicada', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d44);



        $d44 = ['codigo' => 117307, 'nome' => 'Seminário de Tópicos em Matemática Aplicada', 'creditos' => 4, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];

        $db_disciplina_mat = DB::table('disciplinas_mat')->insert($d44);

    }
}
