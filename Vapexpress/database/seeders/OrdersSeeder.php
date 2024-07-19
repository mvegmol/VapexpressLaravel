<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'total_price' => 100.50,
                'address' => '123 Main St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
            [
                'user_id' => 2,
                'total_price' => 200.75,
                'address' => '456 Elm St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
            [
                'user_id' => 1,
                'total_price' => 100.50,
                'address' => '123 Main St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
            [
                'user_id' => 2,
                'total_price' => 200.75,
                'address' => '456 Elm St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
            [
                'user_id' => 1,
                'total_price' => 150.00,
                'address' => '789 Pine St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
            [
                'user_id' => 2,
                'total_price' => 300.20,
                'address' => '321 Oak St, City, Country',
                'status' => 'pending',
                'order_date' => now(),
            ],
        ]);
    }
}
