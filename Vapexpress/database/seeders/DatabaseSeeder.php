<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
        ]);
        $this->call([
            SuppliersSeeder::class,
        ]);
        $this->call([
            ProductsSeeder::class,
        ]);
        $this->call([
            CategoryProductSeeder::class,
        ]);

        $this->call([
            UsersSeeder::class,
        ]);
        $this->call([
            OrdersSeeder::class,
        ]);
        $this->call([
            OrderProductSeeder::class,
        ]);
    }
}
