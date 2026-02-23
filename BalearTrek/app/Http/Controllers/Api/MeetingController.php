<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trek_id = $request->query('trek_id');
            $ordem = $request->query('orden', 'day');
            $direccion = $request->query('direccion', 'desc');
            $pagina = $request->query('pagina', 1);
            $limite = $request->query('limite', 10);

            $query = Meeting::with(['trek', 'guide'])
                ->when($trek_id, fn ($q) =>
                    $q->where('trek_id', $trek_id)
                );

            $ordenesValidas = ['day', 'created_at', 'id'];
            $ordeActual = in_array($ordem, $ordenesValidas) ? $ordem : 'day';
            $dirAccion = strtolower($direccion) === 'asc' ? 'asc' : 'desc';
            
            $query->orderBy($ordeActual, $dirAccion);

            $total = $query->count();
            $meetings = $query->offset(($pagina - 1) * $limite)
                             ->limit($limite)
                             ->get();

            $totalPaginas = ceil($total / $limite);

            return response()->json([
                'data' => $meetings,
                'pagination' => [
                    'pagina_actual' => $pagina,
                    'total_paginas' => $totalPaginas,
                    'total_items' => $total,
                    'items_por_pagina' => $limite,
                ],
                'meta' => 'Meetings mostradas correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar las meetings',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $meeting = Meeting::with(['trek', 'guide', 'comments', 'users'])->findOrFail($id);
            
            return response()->json([
                'data' => $meeting,
                'meta' => 'Meeting mostrada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar la meeting',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date|after:today',
                'max_participants' => 'required|integer|min:1',
                'trek_id' => 'required|exists:treks,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $meeting = Meeting::create($validated);

            return response()->json([
                'data' => $meeting,
                'message' => 'Meeting creada correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la meeting',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            
            $validated = $request->validate([
                'date' => 'date|after:today',
                'max_participants' => 'integer|min:1',
                'trek_id' => 'exists:treks,id',
                'user_id' => 'exists:users,id',
            ]);

            $meeting->update($validated);

            return response()->json([
                'data' => $meeting,
                'message' => 'Meeting actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la meeting',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $meeting->delete();

            return response()->json([
                'message' => 'Meeting eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la meeting',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }
}
