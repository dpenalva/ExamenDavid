<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder principal de la aplicación
 * 
 * Este seeder orquesta la ejecución de todos los seeders
 * del sistema, controlando el orden correcto para respetar
 * las dependencias entre tablas.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Este método se ejecuta cuando llamamos a:
     * - php artisan db:seed
     * - php artisan migrate:fresh --seed
     * 
     * Ejecuta todos los seeders de la aplicación en el orden correcto.
     */
    public function run(): void
    {
        // Crear un usuario de prueba para desarrollo/testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            // La contraseña será 'password' por defecto (definido en el factory)
        ]);

        // IMPORTANTE: El orden de ejecución es fundamental
        
        // 1. Primero creamos las categorías
        // Ejecutamos el seeder de categorías
        $this->call(CategoriaSeeder::class);
        
        // 2. Después creamos los zapatos (que dependen de las categorías)
        // Ejecutamos el seeder de zapatos
        $this->call(ZapatoSeeder::class);
        
        // Si añadimos más seeders en el futuro, debemos mantener
        // el orden correcto según las dependencias entre tablas
    }
}
