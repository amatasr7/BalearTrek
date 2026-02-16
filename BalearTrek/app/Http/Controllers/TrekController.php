<?php
namespace App\Http\Controllers;

use App\Models\Trek;
use App\Models\Municipality;
use App\Models\InterestingPlace;
use Illuminate\Http\Request;

class TrekController extends Controller
{
    public function index()
    {
        $treks = Trek::with('municipality')->paginate(10);
        return view('treks.index', compact('treks'));
    }

    public function create()
    {
        $municipalities = Municipality::all();
        $places = InterestingPlace::all();
        return view('treks.create', compact('municipalities', 'places'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'regNumber' => 'required|unique:treks|max:20',
            'name' => 'required|max:100',
            'municipality_id' => 'required|exists:municipalities,id',
            'places' => 'required|array'
        ]);

        // 1. Creamos la Trek
        $trek = Trek::create($request->only(['regNumber', 'name', 'municipality_id']));

        // 2. Preparamos los IDs de los lugares con el campo 'order'
        // Esto soluciona el error "Field order doesn't have a default value"
        $placesWithOrder = collect($request->input('places'))->mapWithKeys(function ($id) {
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

    public function update(Request $request, string $id)
    {
        // 1. Buscamos la Trek o lanzamos 404 si no existe
        $trek = Trek::findOrFail($id);

        // 2. Validamos los datos básicos
        $request->validate([
            'regNumber' => 'required|max:20|unique:treks,regNumber,' . $id,
            'name' => 'required|max:100',
            'municipality_id' => 'required|exists:municipalities,id',
            'places' => 'required|array'
        ]);

        // 3. Actualizamos los campos de la tabla 'treks'
        $trek->update($request->only(['regNumber', 'name', 'municipality_id']));

        // 4. Preparamos los IDs de los lugares para la tabla pivote con 'order' = 0
        // Esto evita el error: Field 'order' doesn't have a default value
        $placesWithOrder = collect($request->input('places'))->mapWithKeys(function ($id) {
            return [$id => ['order' => 0]];
        })->toArray();

        // 5. Sincronizamos (borra lo viejo y pone lo nuevo en la tabla intermedia)
        $trek->interestingPlaces()->sync($placesWithOrder);

        return redirect()->route('treks.index')
            ->with('success', 'Excursió actualitzada correctament.');
    }

    public function destroy(string $id)
    {
        $trek = Trek::findOrFail($id);

        // 1. Desvincular lugares interesantes (pivote)
        $trek->interestingPlaces()->detach();

        // 2. Navegar por las reuniones
        foreach ($trek->meetings as $meeting) {
            
            // 3. Desvincular usuarios inscritos (pivote meeting_user)
            $meeting->users()->detach();

            // 4. Navegar por los comentarios de la reunión para borrar sus imágenes
            foreach ($meeting->comments as $comment) {
                // 5. Borrar imágenes del comentario (esto soluciona tu error actual)
                $comment->images()->delete();
            }

            // 6. Borrar todos los comentarios de la reunión
            $meeting->comments()->delete();
            
            // 7. Borrar la reunión
            $meeting->delete();
        }

        // 8. Por fin, borrar el Trek
        $trek->delete();

        return redirect()->route('treks.index')->with('success', 'Excursió eliminada amb tota la seva informació.');
    }
    public function show(string $id)
    {
        $trek = Trek::findOrFail($id);
        return view('treks.show', compact('trek'));
    }
}