<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para la tabla de categorías
 * 
 * Este seeder crea las categorías predefinidas para los zapatos.
 * Se usa para poblar la base de datos con datos iniciales.
 */
class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Este método se ejecuta cuando llamamos a php artisan db:seed
     * o cuando ejecutamos migraciones frescas con --seed.
     * 
     * Define las categorías básicas para los zapatos y las inserta en la base de datos.
     */
    public function run(): void
    {
        // Array con las categorías predefinidas
        // Cada categoría tiene un nombre y una descripción
        $categorias = [
            [
                'nombre' => 'Deportivo',
                'descripcion' => 'Zapatos para actividades deportivas y ejercicio físico'
            ],
            [
                'nombre' => 'Casual',
                'descripcion' => 'Zapatos cómodos para uso diario'
            ],
            [
                'nombre' => 'Formal',
                'descripcion' => 'Zapatos elegantes para ocasiones especiales'
            ],
            [
                'nombre' => 'Botas',
                'descripcion' => 'Calzado que cubre el pie y parte del tobillo'
            ],
            [
                'nombre' => 'Sandalias',
                'descripcion' => 'Calzado ligero y abierto para climas cálidos'
            ]
        ];

        // Recorremos el array y creamos cada categoría en la base de datos
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);  // Usa el modelo Categoria para crear los registros
        }
    }
}
