<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Usuário Administrador',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin')
        ]);

        $this->UsersGroup();
    }


    private function UsersGroup()
    {
        DB::table('group_user')->insert([
            'user_id' => 1,
            'group_id' => 1
        ]);
    }
}
