<?php

namespace App\Http\Controllers;
use App\Models\Municipality;
use App\Models\Island;
use App\Models\Zone;
use App\Models\PlaceType;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ]);

        Municipality::create($request->all());
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
    public function update(Request $request, string $id)
{
    // 1. Validamos los datos primero
    $request->validate([
        'name' => 'required|string|max:100',
        'island_id' => 'required|exists:islands,id',
        'zone_id' => 'required|exists:zones,id',
    ]);

    // 2. BUSCAMOS el municipio usando el ID que recibimos
    $municipi = Municipality::findOrFail($id);

    // 3. AHORA SÍ podemos actualizarlo
    $municipi->update($request->all());

    return redirect()->route('municipis.index')
        ->with('success', 'Municipi actualitzat correctament.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(municipality $municipi)
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
