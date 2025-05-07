<?php

namespace App\Http\Controllers;

use App\Models\Zapato;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZapatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Zapatos/Index', [
            'zapatos' => Zapato::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Zapatos/Create');
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
        ]);

        Zapato::create($request->all());

        return redirect()->route('zapatos.index')->with('success', 'Zapato creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zapato $zapato)
    {
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
            'zapato' => $zapato
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
