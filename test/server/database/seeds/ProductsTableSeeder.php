<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
        	'id' => 1,
            'name' => 'Mac Pro',
            'price' => 3000,
            'category_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 2,
            'name' => 'iMac',
            'price' => 3000,
            'category_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 3,
            'name' => 'Macbook Air',
            'price' => 1000,
            'category_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 4,
            'name' => 'Macbook Pro Retina',
            'price' => 2000,
            'category_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 5,
            'name' => 'iPhone 6',
            'price' => 700,
            'category_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 6,
            'name' => 'iPhone 5S',
            'price' => 600,
            'category_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 7,
            'name' => 'iPhone 5C',
            'price' => 500,
            'category_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 8,
            'name' => 'iPhone 6S',
            'price' => 700,
            'category_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 9,
            'name' => 'ipad Pro',
            'price' => 700,
            'category_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 10,
            'name' => 'ipad Air',
            'price' => 500,
            'category_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
        	'id' => 11,
            'name' => 'ipad Mini',
            'price' => 400,
            'category_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
