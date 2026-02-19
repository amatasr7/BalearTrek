<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InterestingPlace;
use Illuminate\Http\Request;

class InterestingPlaceController extends Controller
{
    public function index()
    {
        try {
            $interestingPlaces = InterestingPlace::with('placeType')->get();
            
            return response()->json([
                'data' => $interestingPlaces,
                'meta' => 'Places of interest mostrados correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar los places of interest',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $interestingPlace = InterestingPlace::with('placeType')->findOrFail($id);
            
            return response()->json([
                'data' => $interestingPlace,
                'meta' => 'Place of interest mostrado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar el place of interest',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:100',
                'gps' => 'required|unique:interesting_places',
                'place_type_id' => 'required|exists:place_types,id',
            ]);

            $interestingPlace = InterestingPlace::create($validated);

            return response()->json([
                'data' => $interestingPlace,
                'message' => 'Place of interest creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el place of interest',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $interestingPlace = InterestingPlace::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'max:100',
                'gps' => 'unique:interesting_places,gps,' . $id,
                'place_type_id' => 'exists:place_types,id',
            ]);

            $interestingPlace->update($validated);

            return response()->json([
                'data' => $interestingPlace,
                'message' => 'Place of interest actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el place of interest',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $interestingPlace = InterestingPlace::findOrFail($id);
            $interestingPlace->delete();

            return response()->json([
                'message' => 'Place of interest eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el place of interest',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }
}
