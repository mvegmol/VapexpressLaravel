<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_product')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'price' => 50.25,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 200.75,
            ],
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'price' => 50.25,
            ],
            [
                'order_id' => 6,
                'product_id' => 20,
                'quantity' => 3,
                'price' => 50.25,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 200.75,
            ],
            [
                'order_id' => 3,
                'product_id' => 3,
                'quantity' => 3,
                'price' => 50.00,
            ],
            [
                'order_id' => 4,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 50.00,
            ],
            [
                'order_id' => 5,
                'product_id' => 2,
                'quantity' => 4,
                'price' => 75.05,
            ],
        ]);
    }
}
