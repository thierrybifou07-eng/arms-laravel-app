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
        $query = $floor->rooms()->with('status');

        // Filtre par statut
        if (request('status')) {
            $query->whereHas('status', fn ($q) => $q->where('code', request('status')));
        }

        // Recherche par numéro de chambre
        if (request('search')) {
            $search = request('search');
            $query->where('number', 'like', "%$search%");
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();
        $statuses = \App\Models\RoomStatus::all();
        $building = $floor->building;

        return view('rooms.index', compact('floor', 'rooms', 'statuses', 'building'));
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
        // Check if floor capacity is not exceeded
        $existingCount = $floor->rooms()->count();
        if ($existingCount >= $floor->capacity) {
            return back()->withErrors(['capacity' => "You have reached the maximum number of rooms ({$floor->capacity}) for this floor."]);
        }

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
    public function show(Floor $floor, Room $room)
    {
        return view('rooms.show', compact('floor', 'room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Floor $floor, Room $room)
    {
        $statuses = RoomStatus::all();
        return view('rooms.edit', compact('floor', 'room', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Floor $floor, Room $room)
    {
        $validated = $request->validate([

            'room_status_id' => ['required', 'exists:room_statuses,id'],
            'number' => ['required'],
            'rent' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $room->update($validated);

        return redirect()->route('floors.rooms.index', $floor)->with('success', 'The room has been successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Floor $floor, Room $room)
    {
        if ($room->contracts()->exists()) {
            return redirect()->route('floors.rooms.index', $floor)->withErrors(['message' => 'Impossible to delete a room that has contracts.']);
        }
        $room->delete();

        return redirect()->route('floors.rooms.index', $floor)->with('success', 'The room has been successfully deleted');

    }
}
