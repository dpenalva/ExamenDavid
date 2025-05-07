<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Este método muestra la lista de todas las categorías.
     * Carga el contador de zapatos asociados a cada categoría.
     */
    public function index()
    {
        // withCount('zapatos') añade una columna zapatos_count con el número de zapatos por categoría
        // Esto es útil para saber cuántos zapatos tiene cada categoría sin cargarlos todos
        return Inertia::render('Categorias/Index', [
            'categorias' => Categoria::withCount('zapatos')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Este método muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return Inertia::render('Categorias/Create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Este método procesa el formulario de creación y guarda la nueva categoría.
     * Se encarga de:
     * 1. Validar los datos del formulario
     * 2. Crear la nueva categoría
     * 3. Redireccionar con mensaje de éxito
     */
    public function store(Request $request)
    {
        // Validamos los campos necesarios
        $request->validate([
            'nombre' => 'required|string|max:255',        // Nombre es obligatorio
            'descripcion' => 'nullable|string',           // Descripción es opcional
        ]);

        // Creamos la nueva categoría con los datos validados
        Categoria::create($request->all());

        // Redireccionamos a la lista con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     * 
     * Este método muestra los detalles de una categoría específica.
     * Carga también los zapatos asociados a esta categoría.
     */
    public function show(Categoria $categoria)
    {
        // Cargamos la relación con zapatos para mostrarlos en la vista
        $categoria->load('zapatos');
        
        // Renderizamos la vista de detalle
        return Inertia::render('Categorias/Show', [
            'categoria' => $categoria
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Este método muestra el formulario para editar una categoría existente.
     */
    public function edit(Categoria $categoria)
    {
        return Inertia::render('Categorias/Edit', [
            'categoria' => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * Este método procesa el formulario de edición y actualiza la categoría.
     * Se encarga de:
     * 1. Validar los datos del formulario
     * 2. Actualizar la categoría existente
     * 3. Redireccionar con mensaje de éxito
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validamos los campos necesarios (igual que en store)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Actualizamos la categoría con los datos validados
        $categoria->update($request->all());

        // Redireccionamos a la lista con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Este método elimina una categoría de la base de datos.
     * IMPORTANTE: Verifica que no haya zapatos asociados antes de eliminar.
     * Se encarga de:
     * 1. Verificar si hay zapatos asociados
     * 2. Eliminar la categoría solo si no tiene zapatos
     * 3. Redireccionar con mensaje de éxito o error
     */
    public function destroy(Categoria $categoria)
    {
        // Contamos cuántos zapatos están asociados a esta categoría
        $zapatosCount = $categoria->zapatos()->count();
        
        // Si hay zapatos asociados, no permitimos eliminar la categoría
        if ($zapatosCount > 0) {
            // Redireccionamos con un mensaje de error
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene ' . 
                       $zapatosCount . ' zapatos asociados.');
        }
        
        // Si no hay zapatos asociados, eliminamos la categoría
        $categoria->delete();
        
        // Redireccionamos con mensaje de éxito
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
