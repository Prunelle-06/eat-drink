<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            'email' => 'admin@eatdrink.com',
            'nom_entreprise' => 'Plateforme Admin',
            'role' => 'admin',
            'password' => bcrypt('password-admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
