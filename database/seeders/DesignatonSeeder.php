<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignatonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('designations')->insert(['designation_name' => 'Associative Software Engineer']);
        DB::table('designations')->insert(['designation_name' => 'Software Engineer']);
        DB::table('designations')->insert(['designation_name' => 'Team Lead']);
        DB::table('designations')->insert(['designation_name' => 'Project Manager']);
    }
}
