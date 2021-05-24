<?php

namespace Database\Seeders;

use App\Models\Role;

use App\Models\RoleUsuario;

use App\Models\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('nome', 'admin')->first();

        $coordRole = Role::where('nome', 'coordenador')->first();

        // $editorRole = Role::where('nome', 'editor')->first();

        User::truncate();

        $super_admin = User::create([
            'name' => "José",
            'email' => 'jfreitas.mat@gmail.com',
            'password' => bcrypt('1'),
            'locale' => 'pt_BR',
            'email_verified_at' => now()
        ]);

        $coord = User::create([
            'name' => "Pós Graduação",
            'email' => 'posgrad@mat.unb.br',
            'password' => bcrypt('1'),
            'locale' => 'pt_BR',
            'email_verified_at' => now()
        ]);
        
        $super_admin->roles()->attach($adminRole);

        $coord->roles()->attach($coordRole);

        // $editor->roles()->attach($editorRole);
    }
}
