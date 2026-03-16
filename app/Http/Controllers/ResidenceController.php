<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use App\Models\ResidenceStatus;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residences = Residence::with('status')->paginate(10);

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

        return redirect()->route('residences.index')->with('success', 'La residence à bien été créée');
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

        return redirect()->route('residences.index')->with('success', 'La residence à bien été mise à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Residence $residence)
    {
        $residence->delete();

        return redirect()->route('residences.index')->with('success', 'La residence à bien été supprimée');

    }
}
