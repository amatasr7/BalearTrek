<?php

namespace App\Http\Controllers;
use App\Models\Municipality;
use App\Models\Island;
use App\Models\Zone;
use App\Http\Requests\MunicipalityRequest;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $municipis = Municipality::with(['island', 'zone'])->orderBy('created_at', 'desc')->paginate(10);
        return view('municipis.index', compact('municipis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $islands = Island::all();
        $zones = Zone::all();
        return view('municipis.create', compact('islands', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MunicipalityRequest $request)
    {
        Municipality::create($request->validated());
        return redirect()->route('municipis.index')->with('success', 'Municipi creat!');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    // 1. Buscamos el municipio por su ID. 
    // Si no existe, Laravel lanzará un error 404 automáticamente.
    $municipi = Municipality::findOrFail($id);

    // 2. Cargamos el resto de datos para los desplegables
    $islands = Island::all();
    $zones = Zone::all();

    // 3. Ahora sí, 'municipi' existe y podemos usar compact
    return view('municipis.edit', compact('municipi', 'islands', 'zones'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(MunicipalityRequest $request, string $id)
    {
        $municipi = Municipality::findOrFail($id);
        $municipi->update($request->validated());

    return redirect()->route('municipis.index')
        ->with('success', 'Municipi actualitzat correctament.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipi)
    {
        try {
            $municipi->delete();
            return redirect()->route('municipis.index')
                ->with('success', 'Municipi eliminat.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Si el código es 23000, es que hay lugares (InterestingPlaces) vinculados a este municipio
            if ($e->getCode() == "23000") {
                return redirect()->route('municipis.index')
                    ->with('error', 'No es pot eliminar: Aquest municipi té llocs remarcables associats.');
            }
            throw $e;
        }
    }
    public function show(string $id)
    {
        // Ejemplo para Municipi
        $municipi = Municipality::findOrFail($id);
        return view('municipis.show', compact('municipi'));
    }

}
