<?php

namespace App\Http\Controllers;

use App\Models\Zapato;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZapatoController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Este método muestra la lista de zapatos con paginación y filtros.
     * Se encarga de:
     * 1. Aplicar filtros (categoría, búsqueda de texto)
     * 2. Paginar los resultados
     * 3. Enviar los datos a la vista
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta básica y cargamos la relación con categoría
        // with('categoria') hace un EAGER LOADING para evitar el problema N+1
        $query = Zapato::with('categoria');
        
        // Aplicamos filtro por categoría si existe en la request
        if ($request->has('categoria') && $request->categoria != '') {
            // Filtramos zapatos que pertenezcan a esta categoría
            $query->where('categoria_id', $request->categoria);
        }
        
        // Aplicamos búsqueda de texto si existe en la request
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Usamos una subconsulta para buscar en varios campos
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('talla', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('precio', 'like', "%{$search}%")
                  ->orWhere('stock', 'like', "%{$search}%");
            });
        }
        
        // Paginamos los resultados (3 zapatos por página)
        $zapatos = $query->paginate(3);
        
        // Renderizamos la vista con Inertia.js y pasamos los datos
        return Inertia::render('Zapatos/Index', [
            'zapatos' => $zapatos,                           // Lista paginada de zapatos
            'categorias' => Categoria::all(),                // Todas las categorías para el filtro
            'filters' => $request->only(['search', 'categoria']) // Filtros actuales para mantenerlos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Este método muestra el formulario para crear un nuevo zapato.
     * Carga las categorías disponibles para el select.
     */
    public function create()
    {
        return Inertia::render('Zapatos/Create', [
            'categorias' => Categoria::all() // Pasamos todas las categorías para el select
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Este método procesa el formulario de creación y guarda el nuevo zapato.
     * Se encarga de:
     * 1. Validar los datos del formulario
     * 2. Crear el nuevo zapato
     * 3. Redireccionar con mensaje de éxito
     */
    public function store(Request $request)
    {
        // Validamos todos los campos necesarios con sus reglas
        $request->validate([
            'nombre' => 'required|string|max:255',       // Requerido, texto, máximo 255 caracteres
            'marca' => 'required|string|max:255',        // Requerido, texto, máximo 255 caracteres
            'talla' => 'required|string|max:10',         // Requerido, texto, máximo 10 caracteres
            'color' => 'required|string|max:50',         // Requerido, texto, máximo 50 caracteres
            'precio' => 'required|numeric|min:0',        // Requerido, número, mínimo 0
            'stock' => 'required|integer|min:0',         // Requerido, entero, mínimo 0
            'categoria_id' => 'required|exists:categorias,id', // Debe existir en la tabla categorias
        ]);

        // Creamos el zapato con los datos validados
        Zapato::create($request->all());

        // Redireccionamos a la lista con mensaje de éxito
        return redirect()->route('zapatos.index')->with('success', 'Zapato creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * 
     * Este método muestra los detalles de un zapato específico.
     * Carga la relación con categoría para mostrar sus datos.
     */
    public function show(Zapato $zapato)
    {
        // Cargamos la relación con categoria para acceder a sus datos
        $zapato->load('categoria');
        
        // Renderizamos la vista de detalle
        return Inertia::render('Zapatos/Show', [
            'zapato' => $zapato // Pasamos el zapato a la vista
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Este método muestra el formulario para editar un zapato existente.
     * Carga el zapato y las categorías disponibles.
     */
    public function edit(Zapato $zapato)
    {
        // Renderizamos el formulario de edición
        return Inertia::render('Zapatos/Edit', [
            'zapato' => $zapato,                // El zapato a editar
            'categorias' => Categoria::all()    // Todas las categorías para el select
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * Este método procesa el formulario de edición y actualiza el zapato.
     * Se encarga de:
     * 1. Validar los datos del formulario
     * 2. Actualizar el zapato existente
     * 3. Redireccionar con mensaje de éxito
     */
    public function update(Request $request, Zapato $zapato)
    {
        // Las mismas reglas de validación que en store()
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Actualizamos el zapato con los datos validados
        $zapato->update($request->all());

        // Redireccionamos a la lista con mensaje de éxito
        return redirect()->route('zapatos.index')->with('success', 'Zapato actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Este método elimina un zapato de la base de datos.
     * Se encarga de:
     * 1. Eliminar el zapato
     * 2. Redireccionar con mensaje de éxito
     */
    public function destroy(Zapato $zapato)
    {
        // Eliminamos el zapato
        $zapato->delete();

        // Redireccionamos a la lista con mensaje de éxito
        return redirect()->route('zapatos.index')->with('success', 'Zapato eliminado exitosamente.');
    }
}
