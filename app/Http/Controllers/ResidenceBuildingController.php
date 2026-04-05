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
        $buildings = $residence->buildings()->with('status')->paginate(15);

        return view('buildings.index', compact('residence', 'buildings'));
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
    public function show(string $id, Residence $residence, Building $building)
    {
        return view('buildings.show', compact('residence', 'building'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Residence $residence, Building $building)
    {
        $statuses = BuildingStatus::all();
        return view('buildings.edit', compact('residence', 'building', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Residence $residence, Building $building)
    {
        $validated = $request->validate([

            'building_status_id' => ['required', 'exists:building_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $building->update($validated);

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'Le Bâtiment à bien été mis à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Residence $residence, Building $building)
    {
        $building->delete();

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'Le Bâtiment à bien été supprimée');
    }
}
