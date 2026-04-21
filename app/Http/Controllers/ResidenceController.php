<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Residence;
use App\Models\ResidenceStatus;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Residence $residence)
    {
        $query = Residence::with('status');

        // Filter by statut
        if (request('status')) {
            $query->whereHas('status', fn ($q) => $q->where('code', request('status')));
        }

        // Search city or name
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        }

        $residences = $query->latest()->paginate(10)->withQueryString();

        return view('residences.index', compact('residences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = ResidenceStatus::all();

        return view('residences.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'residence_status_id' => ['required', 'exists:residence_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);

        Residence::create($validated);

        return redirect()->route('residences.index')->with('success', 'The residence has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Residence $residence)
    {
        return view('residences.show', compact('residence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Residence $residence)
    {
        $statuses = ResidenceStatus::all();

        return view('residences.edit', compact('residence', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Residence $residence)
    {
        $validated = $request->validate([

            'residence_status_id' => ['required', 'exists:residence_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $residence->update($validated);

        return redirect()->route('residences.index')->with('success', 'The residence has been successfully updated');

    }

    /**
     * Display all rooms for a residence
     */
    public function rooms(Residence $residence)
    {
        $user = auth()->user();

        // Check if user can access this residence
        if (!$user->canAccessResidence($residence)) {
            abort(403, 'Unauthorized');
        }

        // Query to get all rooms from this residence
        $query = \App\Models\Room::whereHas('floor.building', fn ($q) => $q->where('residence_id', $residence->id))
            ->with(['status', 'floor.building']);

        // Apply status filter
        if (request('status')) {
            $query->whereHas('status', fn ($q) => $q->where('code', request('status')));
        } elseif ($user->hasRole('staff')) {
            // For staff users without explicit status filter, show only busy/renew rooms
            $query->whereHas('status', fn ($q) => $q->whereIn('code', ['busy', 'renew']));
        }

        // Apply search filter
        if (request('search')) {
            $search = request('search');
            $query->where('number', 'like', "%$search%");
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();
        $statuses = \App\Models\RoomStatus::all();
        $roomStatuses = [
            'available' => 'Available',
            'busy' => 'Busy',
            'closed' => 'Closed'
        ];

        return view('residences.rooms', compact('residence', 'rooms', 'statuses', 'roomStatuses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Residence $residence, Building $building)
    {
        if ($residence->buildings()->exists()) {
            return redirect()->route('residences.index')->withErrors(['message' => 'Impossible to delete a residence that contains buildings.']);
        }
        $residence->delete();

        return redirect()->route('residences.index')->with('success', 'The residence has been deleted successfully');

    }
}
