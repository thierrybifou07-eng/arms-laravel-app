<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Floor $floor)
    {
        $rooms = $floor->rooms()->with('status')->get();

        return view('rooms.index', compact('floor', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Floor $floor)
    {
        $statuses = RoomStatus::all();
        return view('rooms.create', compact('floor','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            // Adding room status
            'room_status_id' => ['required', 'exists:room_statuses,id'],
            'number' => ['required','integer', 'min:1',
                Rule::unique('rooms')->where(function ($query) use ($floor) {
                    return $query->where('floor_id', $floor->id);
                }),],
            'rent' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
        ],
            [
                'number.unique' => 'This room already exists in this floor.',

            ]);
        $floor->rooms()->create($validated);

        return redirect()->route('floors.rooms.index', $floor)->with('success', 'The room has been successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Floor $floor, Room $room)
    {
        return view('rooms.show', compact('floor', 'room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Floor $floor, Room $room)
    {
        // Not yet adding buidingstatus here
        return view('rooms.edit', compact('floor', 'room'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Floor $floor, Room $room)
    {
        $validated = $request->validate([

            'room_status_id' => ['required', 'exists:room_statuses,id'],
            'number' => ['required'],
            'rent' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $room->update($validated);

        return redirect()->route('floors.rooms.index', $floor)->with('success', 'Le studio à bien été mis à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Floor $floor, Room $room)
    {
        $room->delete();

        return redirect()->route('floors.rooms.index', $floor)->with('success', 'Le studio à bien été supprimée');

    }
}
