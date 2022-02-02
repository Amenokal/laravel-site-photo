<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('galeries')->insert([
            [
                'name' => 'test',
                'order' => 1,
                'category_id' => 7,
            ],
            [
                'name' => 'test2',
                'order' => 2,
                'category_id' => 8,
            ]
        ]);
    }
}
