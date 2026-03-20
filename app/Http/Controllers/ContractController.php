<?php

namespace App\Http\Controllers;

use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts=Contract::with(['student','room','status'])->latest()->paginate(10);
        return view('contracts.index',compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contracts.create',[
            'students'=> Student::all(),
            'rooms'=> Room::all(),
            'billingPeriods'=>BillingPeriod::all(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'room_id' => 'required|exists:rooms,id',
            'contract_status_id' => 'required|exists:contract_statuses,id',
            'billing_period_id' => 'required|exists:billing_periods,id',
            'rent_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        // bring Id of contract status
        $pendingId = ContractStatus::where('code', 'pending')->value('id');
        $activeId = ContractStatus::where('code', 'active')->value('id');
        // checking overlapping contracts for the same room
        $exists = ContractStatus::where('room_id', $validated['room_id'])->whereIn('contract_status_id', [$pendingId, $activeId])->where(function ($query) use ($validated) {
            $query->where('start_date', '<=', $validated['end_date'])
                ->where('end_date', '>=', $validated['start_date']);

        })->exists();
        if ($exists) {
            return back()->withErrors(['room_id' => 'The room is already booked for the selected period.'], 422);
        }
        //bring the room rent
        $room= Room::find($validated['room_id']);
        //creation of the contract
        Contract::create([
            ...$validated,
            'rent_amount' => $room->rent,
            'contract_status_id' => $pendingId,
        ]);
        return redirect()->back()->with('success', 'Contract created successfully and is pending approval.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
