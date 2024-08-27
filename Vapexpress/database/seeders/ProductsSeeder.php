<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Supplier;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $supplierIds = Supplier::pluck('id')->toArray();
        $usedNames = [];

        for ($i = 0; $i < 100; $i++) {
            do {
                $name = $faker->unique()->word;
            } while (in_array($name, $usedNames)); // Evitar nombres duplicados

            $usedNames[] = $name;

            Product::create([
                'name' => $name,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 1, 20),
                'stock' => $faker->numberBetween(1, 100),
                'url_image' => ($i % 21 + 1) . '.jpg', // Asignar una imagen de 1.jpg a 21.jpg
                'supplier_id' => $faker->randomElement($supplierIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
