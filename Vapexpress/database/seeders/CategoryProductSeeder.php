<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        foreach ($productIds as $productId) {
            // Asigna entre 1 y 3 categorías a cada producto
            $categoriesToAssign = $faker->randomElements($categoryIds, $faker->numberBetween(1, 3));

            foreach ($categoriesToAssign as $categoryId) {
                DB::table('category_products')->insert([
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
