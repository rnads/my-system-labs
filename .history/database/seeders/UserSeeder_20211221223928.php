<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        'name' => 'Usuário Administrador',
        'email' => 'admin@admin.com',
        'email_verified_at' => now(),
        'password' => '',
        );
    }
}


