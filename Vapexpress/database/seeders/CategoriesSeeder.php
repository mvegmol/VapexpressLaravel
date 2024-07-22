<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Vaper Recargable', 'description' => 'Dispositivos de vapeo recargables con baterías duraderas y múltiples opciones de sabor.'],
            ['name' => 'Vaper Desechables', 'description' => 'Vapers de un solo uso, perfectos para probar nuevos sabores sin compromiso.'],
            ['name' => 'Accesorios', 'description' => 'Accesorios esenciales para personalizar y mantener tus dispositivos de vapeo.'],
            ['name' => 'Vaper', 'description' => 'Variedad de vapers para todos los niveles de experiencia y preferencias.'],
            ['name' => 'Sales de Nicotina', 'description' => 'E-líquidos con sales de nicotina para una experiencia de vapeo más suave y satisfactoria.'],
            ['name' => 'E-líquidos', 'description' => 'Amplia gama de e-líquidos con diversos sabores y niveles de nicotina.'],
            ['name' => 'Kits de Inicio', 'description' => 'Paquetes completos para aquellos que se inician en el mundo del vapeo.'],
            ['name' => 'Mods y Baterías', 'description' => 'Dispositivos avanzados y baterías de alta calidad para vapeadores experimentados.'],
            ['name' => 'Atomizadores y Tanques', 'description' => 'Componentes de alta calidad para mejorar la experiencia de vapeo y personalización.'],
            ['name' => 'Cargadores y Estuches', 'description' => 'Soluciones de carga y almacenamiento para mantener tus dispositivos seguros y listos para usar.'],
            ['name' => 'Resistencias y Coils', 'description' => 'Variedad de resistencias y coils para un rendimiento óptimo de tus dispositivos de vapeo.'],
            ['name' => 'Partes de Repuesto', 'description' => 'Piezas de repuesto para mantener tus dispositivos en perfectas condiciones.'],
        ];


        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
