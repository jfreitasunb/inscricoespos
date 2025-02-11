<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = ['nome' => 'José Antônio', 'email' => 'jfreitas.mat@gmail.com', 'password' => bcrypt('1'), 'user_type' => 'admin' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $user = ['nome' => 'Coordenação de Pós-Graduação', 'email' => 'posgrad@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'coordenador' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_user = DB::table('users')->insert($user);

        $candidato = ['nome' => 'Eu Candidato', 'email' => 'eu@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'candidato' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_candidato = DB::table('users')->insert($candidato);

        $recomendante_1 = ['nome' => 'Recomendante 1', 'email' => '1@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'recomendante' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_recomendante_1 = DB::table('users')->insert($recomendante_1);

        $recomendante_2 = ['nome' => 'Recomendante 2', 'email' => '2@mat.unb.br', 'locale' => 'en', 'password' => bcrypt('1'), 'user_type' => 'recomendante' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_recomendante_2 = DB::table('users')->insert($recomendante_2);

        $recomendante_3 = ['nome' => 'Recomendante 3', 'email' => '3@mat.unb.br', 'locale' => 'es',  'password' => bcrypt('1'), 'user_type' => 'recomendante' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $db_recomendante_3 = DB::table('users')->insert($recomendante_3);

        // \App\Models\User::factory(150)->create();
    }
}
