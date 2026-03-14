<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingStatus;
use App\Models\Residence;
use Illuminate\Http\Request;

class ResidenceBuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Residence $residence)
    {
        $buildings = $residence->buildings()->with('status')->get();

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
        $validated = $request->validate([
            // Adding building status
            'building_status_id' => ['required', 'exists:building_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);

        $residence->buildings()->create($validated);

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'Le Bâtiment à bien été créé');
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
        // Not yet adding building dingstatus here
        return view('buildings.edit', compact('residence', 'building'));

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
    public function destroy(string $id, Residence $residence, Building $building)
    {
        $building->delete();

        return redirect()->route('residences.buildings.index', $residence)->with('success', 'Le Bâtiment à bien été supprimée');
    }
}
