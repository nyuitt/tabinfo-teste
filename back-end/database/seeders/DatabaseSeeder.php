<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tabinfo.com.br',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'João Silva',
            'email' => 'joao@tabinfo.com.br',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@tabinfo.com.br',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Pedro Oliveira',
            'email' => 'pedro@tabinfo.com.br',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
