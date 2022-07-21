<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'id' => 1,
            'department' => '',
            'builtin' => 1
        ]);
        DB::table('departments')->insert([
            'id' => 2,
            'department' => 'College of Arts and Sciences',
            'builtin' => 0
        ]);
        DB::table('departments')->insert([
            'id' => 3,
            'department' => 'College of Business Education',
            'builtin' => 0
        ]);
        DB::table('departments')->insert([
            'id' => 4,
            'department' => 'College of Home Economics',
            'builtin' => 0
        ]);
        DB::table('departments')->insert([
            'id' => 5,
            'department' => 'College of Teacher Education',
            'builtin' => 0
        ]);
        DB::table('departments')->insert([
            'id' => 6,
            'department' => 'College of Veterinary Medicine',
            'builtin' => 0
        ]);
    }
}
