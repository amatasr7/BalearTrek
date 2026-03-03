<?php
namespace App\Http\Controllers;

use App\Models\Trek;
use App\Models\Municipality;
use App\Models\InterestingPlace;
use App\Http\Requests\TrekStoreRequest;
use App\Http\Requests\TrekUpdateRequest;
use Illuminate\Support\Arr;

class TrekController extends Controller
{
    public function index()
    {
        $treks = Trek::with('municipality')->orderBy('created_at', 'desc')->paginate(10);
        return view('treks.index', compact('treks'));
    }

    public function create()
    {
        $municipalities = Municipality::all();
        $places = InterestingPlace::all();
        return view('treks.create', compact('municipalities', 'places'));
    }

    public function store(TrekStoreRequest $request)
    {
        $data = $request->validated();
        $trek = Trek::create(
            Arr::only($data, ['regNumber', 'name', 'description', 'municipality_id', 'difficulty'])
        );

    // 2. Preparamos los IDs 
    $placesWithOrder = collect($request->input('interesting_places'))->mapWithKeys(function ($id) {
        return [$id => ['order' => 0]]; 
    })->toArray();

    // 3. Sincronizamos
    $trek->interestingPlaces()->sync($placesWithOrder);

    return redirect()->route('treks.index')->with('success', 'Excursió creada correctament!');
}

    public function edit(string $id)
    {
        $trek = Trek::with('interestingPlaces')->findOrFail($id);
        $municipalities = Municipality::all();
        $places = InterestingPlace::all();
        
        return view('treks.edit', compact('trek', 'municipalities', 'places'));
    }

    public function update(TrekUpdateRequest $request, string $id)
    {
        $trek = Trek::findOrFail($id);
        $data = $request->validated();
        $trek->update(Arr::only($data, ['regNumber', 'name', 'description', 'municipality_id']));

        // 4. Preparamos los IDs de los lugares para la tabla pivote con 'order' = 0
        $placesWithOrder = collect($request->input('places'))->mapWithKeys(function ($id) {
            return [$id => ['order' => 0]];
        })->toArray();

        $trek->interestingPlaces()->sync($placesWithOrder);

        return redirect()->route('treks.index')
            ->with('success', 'Excursió actualitzada correctament.');
    }

    public function destroy(string $id)
    {
        $trek = Trek::findOrFail($id);

        $trek->interestingPlaces()->detach();

        foreach ($trek->meetings as $meeting) {
            
            $meeting->users()->detach();

            foreach ($meeting->comments as $comment) {
                $comment->images()->delete();
            }

            $meeting->comments()->delete();
            
            $meeting->delete();
        }

        $trek->delete();

        return redirect()->route('treks.index')->with('success', 'Excursió eliminada amb tota la seva informació.');
    }
    public function show(string $id)
    {
        $trek = Trek::findOrFail($id);
        return view('treks.show', compact('trek'));
    }
}