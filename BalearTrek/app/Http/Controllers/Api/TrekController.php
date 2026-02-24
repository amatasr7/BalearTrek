<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trek;
use App\Http\Resources\TrekResource;
use App\Models\Municipality;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Comment;
use Carbon\Carbon;  
use Exception;

class TrekController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Parámetros de filtrado
            $isla = $request->query('isla');
            $municipio = $request->query('municipio');
            $ordem = $request->query('orden', 'name'); // Por defecto ordena por nombre
            $direccion = $request->query('direccion', 'asc');
            $pagina = $request->query('pagina', 1);
            $limite = $request->query('limite', 10);

            // CONSTRUCCIÓN DE LA QUERY
            $query = Trek::with(["meetings", "municipality", "municipality.island", "municipality.zone"])
                // Filtrar por isla si se proporciona
                ->when($isla, fn ($q) =>
                    $q->whereHas('municipality.island', fn ($q2) =>
                        $q2->where('name', 'like', "%$isla%")
                    )
                )
                // Filtrar por municipio si se proporciona
                ->when($municipio, fn ($q) =>
                    $q->whereHas('municipality', fn ($q2) =>
                        $q2->where('name', 'like', "%$municipio%")
                    )
                );

            // ORDENAMIENTO
            $ordenesValidas = ['name', 'regNumber', 'totalScore', 'created_at'];
            $ordeActual = in_array($ordem, $ordenesValidas) ? $ordem : 'name';
            $dirAccion = strtolower($direccion) === 'desc' ? 'desc' : 'asc';
            
            $query->orderBy($ordeActual, $dirAccion);

            // PAGINACIÓN
            $total = $query->count();
            $treks = $query->offset(($pagina - 1) * $limite)
                          ->limit($limite)
                          ->get();

            $totalPaginas = ceil($total / $limite);

            // RESPUESTA
            return response()->json([
                'data' => TrekResource::collection($treks),
                'pagination' => [
                    'pagina_actual' => $pagina,
                    'total_paginas' => $totalPaginas,
                    'total_items' => $total,
                    'items_por_pagina' => $limite,
                ],
                'meta' => 'Treks mostrados correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Se produjo un error al recuperar los datos',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Trek $trek)
    {

        // DESHABILITAT

        // AFEGINT DADES AMB 'load()'
        $trek->load(['interestingPlaces',
                     'interestingPlaces.placeType',
                     'meetings',
                     'meetings.comments',
                     'meetings.users',
                     'municipality']);

        // SELECCIÓ DEL FORMAT DE LA RESPOSTA
        // return response()->json($trek);
        return (new TrekResource($trek))->additional(['meta' => 'Trek mostrat correctament']);
    }

    public function store(Request $request)
    {
        try {
            // Validació de les dades
            /*
            $validated = $request->validate([
                'regNumber' => 'required|string|unique:treks,regNumber',
                'name' => 'required|string|max:255',
                'municipality' => 'required|string|exists:municipalities,name',
                'meetings' => 'nullable|array',
                'meetings.*.day' => 'required|date',
                'meetings.*.time' => 'required|date_format:H:i:s',
                'meetings.*.DNI' => 'required|string|exists:users,DNI',
                'meetings.*.comments' => 'nullable|array',
                'meetings.*.comments.*.DNI' => 'required|string|exists:users,DNI',
                'meetings.*.comments.*.comment' => 'required|string',
                'meetings.*.comments.*.score' => 'required|integer|min:0|max:5',
            ]);
            */
            $validated = $request ;

            // Crear el Trek
            $newTrek = Trek::firstOrCreate([
                            'regNumber' => $validated['regNumber'],
                            ],[
                            'name' => $validated['name'],
                            'municipality_id' => Municipality::where('name', $validated['municipality'])->first()->id,
                            ]);

            // Crear les reunions (meetings), si n'hi ha
            foreach ($validated['meetings'] as $meeting) {
                // Buscar l'usuari pel DNI
                $user = User::where('DNI', $meeting['DNI'])->first();
                
                // Crear la reunió
                $newMeeting = Meeting::firstOrCreate(
                                    [ 'trek_id'    => $newTrek->id,
                                        'day'        => $meeting['day'],
                                        'time'       => $meeting['time'],
                                    ],[ 
                                        'user_id'    => User::where('DNI', $meeting['DNI'])->first()->id,
                                        'appDateIni' => Carbon::parse($meeting['day'])->subMonth(),
                                        'appDateEnd' => Carbon::parse($meeting['day'])->subWeek(),
                                    ]);

                // Crear els comentaris si n'hi ha
                foreach ($meeting['comments'] as $comment) {
                    Comment::create([
                        'meeting_id' => $newMeeting->id,
                        'user_id' => User::where('DNI', $comment['DNI'])->first()->id,
                        'comment' => $comment['comment'],
                        'score' => $comment['score'],
                    ]);
                }

            }

            // Carregar les relacions per retornar
            $newTrek->load([
                'interestingPlaces',
                'interestingPlaces.placeType',
                'meetings',
                'meetings.comments',
                'meetings.users',
                'municipality'
            ]);

            return (new TrekResource($newTrek))
                ->additional(['meta' => 'Trek creat correctament'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            // GESTIÓ DE L'ERROR
            // Retorna un JSON amb un missatge d'error i un codi d'estat 500
            return response()->json([
                'message' => 'S\'ha produït un error al tractar les dades',
                // El següent és opcional i només s'hauria de mostrar en entorns de desenvolupament (APP_DEBUG=true)
                'error_details' => $e->getMessage(),
            ], 200);
        }
    }

    public function update(Request $request, string $id)
    {
        // DESHABILITAT
        return response()->json([
            'message' => 'Mètode no implementat'
        ], 501);
    }

    public function destroy(string $id)
    {
        // DESHABILITAT
        return response()->json([
            'message' => 'Mètode no implementat'
        ], 501);
    }

    public function find($value)
    {
        // Preparar la query amb totes les relacions
        $query = Trek::with([
            'interestingPlaces',
            'interestingPlaces.placeType',
            'meetings',
            'meetings.comments',
            'meetings.users',
            'municipality'
        ]);

        // Cercar per ID (numèric) o per regNumber/municipality (alfanumèric)
        $trek = is_numeric($value)
            ? $query->findOrFail($value)  // Cerca per ID
            : $query->where('regNumber', $value)  // Cerca per regNumber
                    ->orWhereHas('municipality', function ($q) use ($value) {
                            $q->where('name', $value);  // O per nom del municipi
                        })
                    ->firstOrFail();
        
        // return response()->json($trek);
        return (new TrekResource($trek))->additional(['meta' => 'Trek trobat correctament']);
    }

public function getFeatured()
    {
        // Criterio: Las 3 excursiones con mejor puntuación
        $featured = Trek::orderByDesc('totalScore') 
            ->take(3)
            ->get();

        return response()->json([
            'data' => $featured,
            'criteria' => 'Basado en la puntuación de los usuarios'
        ]);
    }
}
