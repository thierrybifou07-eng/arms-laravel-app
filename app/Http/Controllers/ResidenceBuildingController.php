<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingStatus;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidenceBuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Residence $residence)
    {
        $query = $residence->buildings()->with('status');

        // Filtre par statut
        if (request('status')) {
            $query->whereHas('status', fn ($q) => $q->where('code', request('status')));
        }

        // Recherche par nom ou adresse
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%$search%")
                  /* ->orWhere('address', 'like', "%$search%") */;
        }

        $buildings = $query->latest()->paginate(10)->withQueryString();
        $statuses = BuildingStatus::all();

        return view('buildings.index', compact('residence', 'buildings', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Residence $residence)
    {
        $statuses = BuildingStatus::all();

        return view('buildings.create', compact('residence','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Residence $residence)
    {
        // Check if residence capacity is not exceeded
        $existingCount = $residence->buildings()->count();
        if ($existingCount >= $residence->capacity) {
            return back()->withErrors(['capacity' => "You have reached the maximum number of buildings ({$residence->capacity}) for this residence."]);
        }

        $validated = $request->validate([
            // Adding building status
            'building_status_id' => ['required', 'exists:building_statuses,id'],
            'name' => ['required','string','max:255',
                Rule::unique('buildings')->where(function ($query) use ($residence) {
                    return $query->where('residence_id', $residence->id);
                }),],
            'address' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
         ],
            [
                'name.unique' => 'This building already exists in this residence.',
            ]);
        $residence->buildings()->create($validated);

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'The building has been successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Residence $residence, Building $building)
    {
        return view('buildings.show', compact('residence', 'building'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Residence $residence, Building $building)
    {
        $statuses = BuildingStatus::all();
        return view('buildings.edit', compact('residence', 'building', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Residence $residence, Building $building)
    {
        $validated = $request->validate([

            'building_status_id' => ['required', 'exists:building_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $building->update($validated);

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'The building has been successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Residence $residence, Building $building)
    {
        if ($building->floors()->exists()) {
            return redirect()->route('residences.buildings.index', $residence)->withErrors(['message' => 'Impossible to delete a building that contains floors.']);
        }
        $building->delete();

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'The building has been successfully deleted');
    }
}
