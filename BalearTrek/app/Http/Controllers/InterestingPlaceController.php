<?php

namespace App\Http\Controllers;

use App\Models\InterestingPlace;
use App\Models\PlaceType;
use Illuminate\Http\Request;

class InterestingPlaceController extends Controller
{
    public function index()
    {
        // 1. La variable se llama $interestingPlaces (en plural)
        $interestingPlaces = InterestingPlace::with('placeType')->paginate(10);

        // 2. La vista usa puntos para las carpetas y guion bajo para el archivo
        // 3. Pasamos 'interestingPlaces' (el mismo nombre que arriba)
        return view('interesting_places.index', compact('interestingPlaces'));
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
    public function show(string $id)
    {
        $interestingPlace = InterestingPlace::findOrFail($id);
        return view('interesting_places.show', compact('interestingPlace'));
    }
}
