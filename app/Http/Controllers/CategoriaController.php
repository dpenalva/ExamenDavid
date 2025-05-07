<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Categorias/Index', [
            'categorias' => Categoria::withCount('zapatos')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Categorias/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string'
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $categoria->loadCount('zapatos');
        $categoria->load('zapatos');
        
        return Inertia::render('Categorias/Show', [
            'categoria' => $categoria
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return Inertia::render('Categorias/Edit', [
            'categoria' => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string'
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        // Verificar si hay zapatos asociados a esta categoría
        if ($categoria->zapatos()->count() > 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'No se puede eliminar esta categoría porque tiene zapatos asociados.'], 422);
            }
            return redirect()->route('categorias.index')->with('error', 'No se puede eliminar esta categoría porque tiene zapatos asociados.');
        }
        
        $categoria->delete();

        // Para peticiones AJAX (Axios)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => 'Categoría eliminada exitosamente'], 200);
        }

        // Para redirecciones normales
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
