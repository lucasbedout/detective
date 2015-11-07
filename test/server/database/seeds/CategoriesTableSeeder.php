<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        	'id' => 1,
            'name' => 'Home computer',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insert([
        	'id' => 2,
            'name' => 'Laptop',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insert([
        	'id' => 3,
            'name' => 'Phone',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insert([
        	'id' => 4,
            'name' => 'Tablet',
        	'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
