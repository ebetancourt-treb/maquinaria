<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@maquinaria.test'],
            ['name'=>'Administrador','password'=>bcrypt('password'),'puesto'=>'Administrador del Sistema','activo'=>true]
        );
        $admin->assignRole('admin');
    }
}
