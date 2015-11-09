<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
        	'id' => 1,
            'name' => 'Paris Flagship Store',
            'address' => '6 place Monge',
            'zip_code' => '75003',
            'city' => 'Paris',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('stores')->insert([
        	'id' => 2,
            'name' => 'London Flagship Store',
            'address' => '6 Picadilly Circus',
            'zip_code' => 'PE899',
            'city' => 'London',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('stores')->insert([
        	'id' => 3,
            'name' => 'Madrid Flagship Store',
            'address' => '6 plaja Rojo',
            'zip_code' => '099RR',
            'city' => 'Madrid',
        	'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('stores')->insert([
        	'id' => 4,
            'name' => 'New York Flagship Store',
            'address' => '6 V Avenue',
            'zip_code' => 'NY9800',
            'city' => 'New York',
        	'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
