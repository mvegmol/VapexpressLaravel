<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapeo de imágenes a nombres de categorías
        $categoryMap = [
            '1.jpg' => ['Vaper Desechables', 'Vaper'],
            '2.jpg' => ['Vaper Desechables', 'Vaper'],
            '3.jpg' => ['Vaper Desechables', 'Vaper'],
            '4.jpg' => ['Vaper Desechables', 'Vaper'],
            '5.jpg' => ['Vaper Desechables', 'Vaper'],
            '6.jpg' => ['Vaper Desechables', 'Vaper'],
            '7.jpg' => ['Vaper Desechables', 'Vaper'],
            '8.jpg' => ['Vaper Desechables', 'Vaper'],
            '9.jpg' => ['Vaper Desechables', 'Vaper'],
            '10.jpg' => ['Vaper Recargable', 'Vaper', 'Kits de Inicio'],
            '11.jpg' => ['Vaper Desechables', 'Vaper', 'Kits de Inicio'],
            '12.jpg' => ['E-líquidos', 'Sales de Nicotina', 'Accesorios'],
            '13.jpg' => ['E-líquidos', 'Sales de Nicotina'],
            '14.jpg' => ['E-líquidos', 'Sales de Nicotina'],
            '15.jpg' => ['E-líquidos', 'Sales de Nicotina'],
            '16.jpg' => ['Partes de Repuesto', 'Resistencias y Coils', 'Accesorios'],
            '17.jpg' => ['Partes de Repuesto', 'Resistencias y Coils', 'Accesorios'],
            '18.jpg' => ['Vaper Recargable', 'Vaper'],
            '19.jpg' => ['Vaper Recargable', 'Vaper'],
            '20.jpg' => ['Vaper Recargable', 'Vaper', 'Kits de Inicio', 'Mods y Baterías'],
            '21.jpg' => ['Cargadores y Estuches', 'Accesorios'],
        ];

        // Obtener todos los productos
        $products = Product::all();

        foreach ($products as $product) {
            $imageName = $product->url_image;

            // Obtener las categorías a asignar según el nombre de la imagen
            $categoriesToAssign = $categoryMap[$imageName] ?? [];

            foreach ($categoriesToAssign as $categoryName) {
                // Obtener el ID de la categoría por su nombre
                $category = Category::where('name', $categoryName)->first();

                if ($category) {
                    // Insertar la relación en la tabla pivot
                    DB::table('category_product')->insert([
                        'product_id' => $product->id,
                        'category_id' => $category->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    // Opcionalmente, manejar el caso en que la categoría no exista
                    // Ejemplo: throw new \Exception("Categoría '{$categoryName}' no encontrada.");
                }
            }
        }
    }
}
