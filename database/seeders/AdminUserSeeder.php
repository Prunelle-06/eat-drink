<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            'nom_complet' => 'Administrateur Plateforme',
            'email' => 'admin@tastestay.com',
            'type' => 'admin',
            'password' => Hash::make('password-admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
