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
        // $user = ['nome' => 'José Antônio', 'email' => 'jfreitas.mat@gmail.com', 'password' => bcrypt('1'), 'user_type' => 'admin' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        // $db_user = DB::table('users')->insert($user);

        // $user = ['nome' => 'Coordenação de Pós-Graduação', 'email' => 'posgrad@mat.unb.br', 'password' => bcrypt('1'), 'user_type' => 'coordenador' , 'email_verified_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        // $db_user = DB::table('users')->insert($user);

        \App\Models\User::factory(50)->create();
    }
}
