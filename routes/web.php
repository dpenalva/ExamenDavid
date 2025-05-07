<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZapatoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Zapato;
use App\Models\Categoria;

/**
 * Ruta principal - Página de bienvenida
 * 
 * Muestra la vista Welcome con:
 * 1. Zapatos destacados aleatorios para el carrusel
 * 2. Lista de categorías con contador de zapatos
 * 3. Datos sobre el entorno de Laravel
 */
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),         // Verifica si existe la ruta de login
        'canRegister' => Route::has('register'),   // Verifica si existe la ruta de registro
        'laravelVersion' => Application::VERSION,  // Versión de Laravel
        'phpVersion' => PHP_VERSION,               // Versión de PHP
        'zapatosDestacados' => Zapato::inRandomOrder()->limit(5)->get(), // 5 zapatos aleatorios
        'categorias' => Categoria::withCount('zapatos')->get()           // Categorías con contador
    ]);
})->name('home'); // Nombre de la ruta para poder referenciarla con route('home')

/**
 * Ruta del dashboard - Redirección a zapatos
 * 
 * Esta ruta redirige al usuario desde /dashboard hacia la lista de zapatos.
 * Requiere que el usuario esté autenticado y verificado.
 */
Route::get('/dashboard', function () {
    return redirect()->route('zapatos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Rutas para el CRUD de zapatos
 * 
 * Crea automáticamente todas estas rutas:
 * - GET /zapatos - index() - Listar todos los zapatos
 * - GET /zapatos/create - create() - Mostrar formulario de creación
 * - POST /zapatos - store() - Guardar un nuevo zapato
 * - GET /zapatos/{zapato} - show() - Ver un zapato específico
 * - GET /zapatos/{zapato}/edit - edit() - Mostrar formulario de edición
 * - PUT/PATCH /zapatos/{zapato} - update() - Actualizar un zapato
 * - DELETE /zapatos/{zapato} - destroy() - Eliminar un zapato
 */
Route::resource('zapatos', ZapatoController::class);

/**
 * Rutas para el CRUD de categorías
 * 
 * Igual que con zapatos, crea automáticamente todas las rutas necesarias
 * para gestionar las categorías (index, create, store, show, edit, update, destroy)
 */
Route::resource('categorias', CategoriaController::class);

/**
 * Ruta para buscar zapatos (API)
 * 
 * Esta es una ruta de API para buscar zapatos por varios campos.
 * Se puede usar en componentes como select2 o para autocompletado.
 */
Route::get('/zapatos/buscar', function(Request $request) {
    $query = $request->input('q');
    
    // Si no hay término de búsqueda, devolvemos todos los zapatos
    if (empty($query)) {
        return Zapato::all();
    }
    
    // Búsqueda en múltiples campos
    return Zapato::where('id', 'like', "%{$query}%")
                ->orWhere('nombre', 'like', "%{$query}%")
                ->orWhere('marca', 'like', "%{$query}%")
                ->orWhere('talla', 'like', "%{$query}%")
                ->orWhere('color', 'like', "%{$query}%")
                ->orWhere('precio', 'like', "%{$query}%")
                ->orWhere('stock', 'like', "%{$query}%")
                ->get();
});

/**
 * Rutas de perfil de usuario
 * 
 * Estas rutas permiten al usuario gestionar su perfil.
 * Requieren que el usuario esté autenticado.
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Importa las rutas de autenticación (login, registro, recuperación de contraseña, etc.)
require __DIR__.'/auth.php';
