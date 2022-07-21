<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'id_number' => 1,
            'firstname' => 'Anthony Carl',
            'lastname' => 'Meniado',
            'mobile_no' => '09177402785',
            'email' => 'carlsus@gmail.com',
            'password' => bcrypt('password'),
            'department_id' => 1,
            'user_type' => 'Users',
            'builtin' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'id_number' => 2,
            'firstname' => 'System',
            'lastname' => 'Administrator',
            'mobile_no' => '01234567890',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'department_id' => 2,
            'user_type' => 'Users',
            'builtin' => 0
        ]);
    }
}
