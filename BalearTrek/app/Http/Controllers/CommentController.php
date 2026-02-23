<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Muestra el listado de comentarios.
     */
    public function index()
    {
        $comments = Comment::with(['user', 'meeting.trek', 'images'])->latest()->paginate(10);
        return view('comments.index', compact('comments'));
    }

    /**
     * Muestra el detalle de un comentario.
     */
    public function show(Comment $comment)
    {
        // Cargamos las relaciones para evitar errores en la vista show
        $comment->load(['user', 'meeting.trek', 'images']);
        return view('comments.show', compact('comment'));
    }

    /**
     * Valida el comentario cambiando el status a 'y'.
     */
    public function validateComment(Comment $comment)
    {
        // Actualizamos el status en la base de datos
        $comment->update(['status' => 'y']);
        return redirect()->route('comments.index')->with('success', 'Comment validated successfully.');
    }

    /**
     * Elimina el comentario y sus imágenes asociadas.
     */
    public function destroy(Comment $comment)
    {
        // Al eliminar el comentario, se eliminan los registros de imágenes por la relación
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Comment and associated images deleted.');
    }
}