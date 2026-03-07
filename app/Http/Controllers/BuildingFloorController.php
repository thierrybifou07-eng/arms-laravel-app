<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class BuildingFloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Building $building)
    {
        $floors = $building->floors()->with('status')->get();

        return view('floors.index', compact('building', 'floors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Building $building)
    {
        return view('floors.create', compact('building'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Building $building)
    {
        $validated = $request->validate([
            // Adding floor status

            'floor_status_id' => ['required', 'exists:floor_statuses,id'],
            'number' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $building->floors()->create($validated);

        return redirect()->route('buildings.floors.index', $building)->with('success', 'Le palier à bien été créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Building $building, Floor $floor)
    {
        return view('floors.show', compact('building', 'floor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Building $building, Floor $floor)
    {
        // Not yet adding buidingstatus here
        return view('floors.edit', compact('building', 'floor'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Building $building, Floor $floor)
    {
        $validated = $request->validate([

            'floor_status_id' => ['required', 'exists:floor_statuses,id'],
            'number' => ['required'],
            'capacity' => ['required', 'integer', 'min:1'],

        ]);
        $floor->update($validated);

        return redirect()->route('buildings.floors.index', $building)->with('success', 'Le palier à bien été mis à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Building $building, Floor $floor)
    {
        $floor->delete();

        return redirect()->route('buildings.floors.index', $building)->with('success', 'Le palier à bien été supprimée');

    }
}
