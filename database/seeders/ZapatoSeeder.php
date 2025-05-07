<?php

namespace Database\Seeders;

use App\Models\Zapato;
use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZapatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos las categorías
        $categoriaDeportiva = Categoria::where('nombre', 'Deportivo')->first()->id;
        $categoriaCasual = Categoria::where('nombre', 'Casual')->first()->id;
        $categoriaFormal = Categoria::where('nombre', 'Formal')->first()->id;
        
        $zapatos = [
            [
                'nombre' => 'Air Classic',
                'marca' => 'Nike',
                'talla' => '42',
                'color' => 'Negro',
                'precio' => 89.99,
                'stock' => 15,
                'categoria_id' => $categoriaDeportiva
            ],
            [
                'nombre' => 'Ultraboost',
                'marca' => 'Adidas',
                'talla' => '43',
                'color' => 'Blanco',
                'precio' => 129.99,
                'stock' => 8,
                'categoria_id' => $categoriaDeportiva
            ],
            [
                'nombre' => 'Classic Leather',
                'marca' => 'Reebok',
                'talla' => '41',
                'color' => 'Marrón',
                'precio' => 75.50,
                'stock' => 12,
                'categoria_id' => $categoriaFormal
            ],
            [
                'nombre' => 'Old Skool',
                'marca' => 'Vans',
                'talla' => '40',
                'color' => 'Negro/Blanco',
                'precio' => 65.00,
                'stock' => 20,
                'categoria_id' => $categoriaCasual
            ],
            [
                'nombre' => 'Chuck Taylor',
                'marca' => 'Converse',
                'talla' => '44',
                'color' => 'Rojo',
                'precio' => 59.99,
                'stock' => 18,
                'categoria_id' => $categoriaCasual
            ]
        ];

        foreach ($zapatos as $zapato) {
            Zapato::create($zapato);
        }
    }
} 