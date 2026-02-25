<?php
namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Trek;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['trek', 'guide'])->paginate(10); 
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $treks = Trek::all();
        // Buscamos solo usuarios que sean guías
        $guides = User::whereHas('role', function($q) {
            $q->where('name', 'guia');
        })->get();

        return view('meetings.create', compact('treks', 'guides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:today',
            'max_participants' => 'required|integer|min:1',
            'trek_id' => 'required|exists:treks,id',
            'user_id' => 'required|exists:users,id', // El guía
        ]);

        Meeting::create($request->all());

        return redirect()->route('meetings.index')->with('success', 'Trobada creada!');
    }

    public function edit(string $id)
    {
        $meeting = Meeting::findOrFail($id);
        $treks = Trek::all();
        $guides = User::whereHas('role', function($q) {
            $q->where('name', 'guia');
        })->get();

        return view('meetings.edit', compact('meeting', 'treks', 'guides'));
    }

    public function update(Request $request, string $id)
{
    $meeting = Meeting::findOrFail($id);

    $validated = $request->validate([
        'trek_id' => 'required|exists:treks,id',
        'user_id' => 'required|exists:users,id',
        'day' => 'required|date',
        'time' => 'required',
        'appDateIni' => 'required|date',
        'appDateEnd' => 'required|date|after_or_equal:appDateIni',
    ]);

    $meeting->update($validated);

    return redirect()->route('meetings.index')->with('success', 'Trobada actualitzada correctament');
}

    public function destroy(string $id)
    {
        $meeting = Meeting::findOrFail($id);

        $meeting->comments()->delete();

        $meeting->delete();

        return redirect()->route('meetings.index')->with('success', 'Trobada i comentaris eliminats!');
    }
    public function show(string $id)
    {
        $meeting = Meeting::with(['trek', 'guide', 'comments.user'])->findOrFail($id);

        return view('meetings.show', compact('meeting'));
    }
}