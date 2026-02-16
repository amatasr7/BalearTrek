<?php

namespace App\Http\Controllers;

use App\Models\InterestingPlace;
use App\Models\PlaceType;
use Illuminate\Http\Request;

class InterestingPlaceController extends Controller
{
    public function index()
    {
        $places = InterestingPlace::with('placeType')->paginate(10);
        return view('interesting_places.index', compact('places'));
    }

    public function create()
    {
        $types = PlaceType::all();
        return view('interesting_places.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'gps' => 'required|unique:interesting_places',
            'place_type_id' => 'required|exists:place_types,id',
        ]);

        InterestingPlace::create($request->all());
        return redirect()->route('interesting-places.index')->with('success', 'Lloc creat correctament!');
    }

    public function edit(InterestingPlace $interestingPlace)
    {
        $types = PlaceType::all();
        return view('interesting_places.edit', compact('interestingPlace', 'types'));
    }

    public function update(Request $request, InterestingPlace $interestingPlace)
    {
        $request->validate([
            'name' => 'required|max:100',
            'gps' => 'required|unique:interesting_places,gps,' . $interestingPlace->id,
            'place_type_id' => 'required|exists:place_types,id',
        ]);

        $interestingPlace->update($request->all());
        return redirect()->route('interesting-places.index')->with('success', 'Actualitzat!');
    }

    public function destroy(InterestingPlace $interestingPlace)
    {
        // Este "detach" borra las entradas en la tabla intermedia interesting_place_trek
        // sin borrar las excursiones en sí.
        $interestingPlace->treks()->detach(); 

        $interestingPlace->delete();

        return redirect()->route('interesting-places.index')->with('success', 'Lloc eliminat correctament');
    }
    public function show($id)
{
    // Buscamos el lugar con su relación para evitar errores
    $place = InterestingPlace::with('placeType')->findOrFail($id);

    // Es vital que el nombre en compact() coincida con el de la vista
    return view('interesting_places.show', compact('place'));
}
}
