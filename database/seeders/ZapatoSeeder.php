<?php

namespace Database\Seeders;

use App\Models\Zapato;
use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para la tabla de zapatos
 * 
 * Este seeder crea zapatos de ejemplo para poblar la base de datos.
 * Depende de que el CategoriaSeeder se haya ejecutado primero
 * ya que necesita las categorías para asignarlas a los zapatos.
 */
class ZapatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Este método se ejecuta cuando llamamos a php artisan db:seed
     * o cuando ejecutamos migraciones frescas con --seed.
     * 
     * Crea zapatos de ejemplo con datos realistas y los asigna
     * a las categorías correspondientes.
     */
    public function run(): void
    {
        // Obtenemos los IDs de las categorías existentes
        // Esto asume que el CategoriaSeeder ya se ha ejecutado
        $categoriaDeportiva = Categoria::where('nombre', 'Deportivo')->first()->id;
        $categoriaCasual = Categoria::where('nombre', 'Casual')->first()->id;
        $categoriaFormal = Categoria::where('nombre', 'Formal')->first()->id;
        
        // Array con los zapatos de ejemplo
        // Cada zapato tiene todos los campos requeridos por el modelo
        $zapatos = [
            [
                'nombre' => 'Air Classic',           // Nombre del modelo
                'marca' => 'Nike',                   // Marca
                'talla' => '42',                     // Talla europea
                'color' => 'Negro',                  // Color principal
                'precio' => 89.99,                   // Precio en euros
                'stock' => 15,                       // Unidades disponibles
                'categoria_id' => $categoriaDeportiva // Categoría (deportivo)
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
                'categoria_id' => $categoriaFormal // Categoría (formal)
            ],
            [
                'nombre' => 'Old Skool',
                'marca' => 'Vans',
                'talla' => '40',
                'color' => 'Negro/Blanco',
                'precio' => 65.00,
                'stock' => 20,
                'categoria_id' => $categoriaCasual // Categoría (casual)
            ],
            [
                'nombre' => 'Chuck Taylor',
                'marca' => 'Converse',
                'talla' => '44',
                'color' => 'Rojo',
                'precio' => 59.99,
                'stock' => 18,
                'categoria_id' => $categoriaCasual // Categoría (casual)
            ]
        ];

        // Recorremos el array y creamos cada zapato en la base de datos
        foreach ($zapatos as $zapato) {
            Zapato::create($zapato); // Usa el modelo Zapato para crear los registros
        }
    }
} 