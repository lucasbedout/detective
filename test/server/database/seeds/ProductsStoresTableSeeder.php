<?php

use Illuminate\Database\Seeder;

class ProductsStoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_stores')->insert([
           	'product_id' => 1,
           	'store_id' => 1,
           	'quantity' => 10,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 1,
           	'store_id' => 2,
           	'quantity' => 8,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 1,
           	'store_id' => 3,
           	'quantity' => 0,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 1,
           	'store_id' => 4,
           	'quantity' => 14,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 2,
           	'store_id' => 1,
           	'quantity' => 6,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 2,
           	'store_id' => 2,
           	'quantity' => 10,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 2,
           	'store_id' => 3,
           	'quantity' => 7,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 2,
           	'store_id' => 4,
           	'quantity' => 3,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 3,
           	'store_id' => 1,
           	'quantity' => 6,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 3,
           	'store_id' => 2,
           	'quantity' => 10,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 3,
           	'store_id' => 3,
           	'quantity' => 7,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 3,
           	'store_id' => 4,
           	'quantity' => 3,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 4,
           	'store_id' => 1,
           	'quantity' => 6,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 4,
           	'store_id' => 2,
           	'quantity' => 10,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 5,
           	'store_id' => 3,
           	'quantity' => 7,
           	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products_stores')->insert([
           	'product_id' => 5,
           	'store_id' => 4,
           	'quantity' => 3,
           	'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}	
