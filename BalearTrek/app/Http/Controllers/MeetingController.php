<?php
namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Trek;
use App\Models\User;
use App\Http\Requests\MeetingStoreRequest;
use App\Http\Requests\MeetingUpdateRequest;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['trek', 'guide'])->orderBy('created_at', 'desc')->paginate(10); 
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

    public function store(MeetingStoreRequest $request)
    {
        Meeting::create($request->validated());
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

    public function update(MeetingUpdateRequest $request, string $id)
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->update($request->validated());

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