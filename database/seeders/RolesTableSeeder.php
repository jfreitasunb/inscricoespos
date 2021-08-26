<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create(['nome' => 'admin', 'descricao' => 'Administrador do sistema.']);
        Role::create(['nome' => 'coordenador', 'descricao' => 'Coordenação da Pós Graduação.']);
        Role::create(['nome' => 'candidato', 'descricao' => 'Aplicantes a uma vaga na Pós Graduação.']);
        Role::create(['nome' => 'recomendante', 'descricao' => 'Pessoa que irá enviar a carta de recomendação.']);
    }
}
