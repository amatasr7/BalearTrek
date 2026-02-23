<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        //Ordenados de más reciente a más antiguo
        $query = Comment::with(['user', 'meeting.trek'])
            ->where('validat', true) // Solo comentarios validados
            ->latest();

        // Filtro opcional por excursión
        if ($request->has('trek_id')) {
            $query->where('trek_id', $request->trek_id);
        }

        // Paginación de 6 en 6 
        return $query->paginate(6);
    }
}