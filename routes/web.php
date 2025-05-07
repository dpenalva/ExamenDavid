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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'zapatosDestacados' => Zapato::inRandomOrder()->limit(5)->get(),
        'categorias' => Categoria::withCount('zapatos')->get()
    ]);
})->name('home');

// Redirección desde dashboard a zapatos
Route::get('/dashboard', function () {
    return redirect()->route('zapatos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para el CRUD de zapatos
Route::resource('zapatos', ZapatoController::class);

// Rutas para el CRUD de categorías
Route::resource('categorias', CategoriaController::class);

// Ruta para buscar zapatos
Route::get('/zapatos/buscar', function(Request $request) {
    $query = $request->input('q');
    
    if (empty($query)) {
        return Zapato::all();
    }
    
    return Zapato::where('id', 'like', "%{$query}%")
                ->orWhere('nombre', 'like', "%{$query}%")
                ->orWhere('marca', 'like', "%{$query}%")
                ->orWhere('talla', 'like', "%{$query}%")
                ->orWhere('color', 'like', "%{$query}%")
                ->orWhere('precio', 'like', "%{$query}%")
                ->orWhere('stock', 'like', "%{$query}%")
                ->get();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
