<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
