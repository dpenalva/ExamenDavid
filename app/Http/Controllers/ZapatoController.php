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
     */
    public function index(Request $request)
    {
        $query = Zapato::with('categoria');
        
        // Filtro por categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }
        
        // Búsqueda por texto
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('talla', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('precio', 'like', "%{$search}%")
                  ->orWhere('stock', 'like', "%{$search}%");
            });
        }
        
        // Paginar los resultados
        $zapatos = $query->paginate(3);
        
        return Inertia::render('Zapatos/Index', [
            'zapatos' => $zapatos,
            'categorias' => Categoria::all(),
            'filters' => $request->only(['search', 'categoria'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Zapatos/Create', [
            'categorias' => Categoria::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Zapato::create($request->all());

        return redirect()->route('zapatos.index')->with('success', 'Zapato creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zapato $zapato)
    {
        $zapato->load('categoria');
        
        return Inertia::render('Zapatos/Show', [
            'zapato' => $zapato
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zapato $zapato)
    {
        return Inertia::render('Zapatos/Edit', [
            'zapato' => $zapato,
            'categorias' => Categoria::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zapato $zapato)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $zapato->update($request->all());

        return redirect()->route('zapatos.index')->with('success', 'Zapato actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zapato $zapato)
    {
        $zapato->delete();

        return redirect()->route('zapatos.index')->with('success', 'Zapato eliminado exitosamente.');
    }
}
