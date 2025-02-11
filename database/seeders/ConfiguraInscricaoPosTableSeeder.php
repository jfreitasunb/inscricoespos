<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguraInscricaoPosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \DB::table('configura_inscricao_pos')->delete();

        \DB::table('configura_inscricao_pos')->insert(array (
            0 =>
                array (
                    'inicio_inscricao' => '2025-01-01',
                    'fim_inscricao' => '2025-12-01',
                    'prazo_carta' => '2025-12-15',
                    'data_homologacao' => '2025-12-20',
                    'data_divulgacao_resultado' => '2025-12-20',
                    'necessita_recomendante' => True,
                    'necessita_semestre_inicio' => False,
                    'programa' => '1_2',
                    'edital' => '2025-1',
                    'id_coordenador' => '2',
                    'created_at' => '2025-02-11 10:00:00',
                    'updated_at' => '2025-02-11 10:00:00'
                ),
        ));

        $tableToCheck = 'configura_inscricao_pos';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id)'))->first();

        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_seq\', '.$highestId->max.')');
    }
}
