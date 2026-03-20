<?php

namespace App\Http\Controllers;

use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\Room;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with(['student', 'room', 'status'])->latest()->paginate(10);

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contracts.create', [
            'students' => Student::all(),
            'rooms' => Room::all(),
            'billingPeriods' => BillingPeriod::all(),
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        // bring Id of contract status
        $activeId = ContractStatus::where('code', 'active')->value('id');
        // checking overlapping contracts for the same room
        if (Contract::hasOverlap(
            $validated['room_id'],
            $validated['start_id'],
            $validated['end_id'],
        )) {
            return back()->withErrors(['room_id' => 'The room is already booked for the selected period.'], 422);

        }
        $pendingId = ContractStatus::where('code', 'pending')->value('id');
        // bring the room rent
        $room = Room::findOrFail($validated['room_id']);
        // creation of the contract
        Contract::create([
            ...$validated,
            'rent_amount' => $room->rent,
            'contract_status_id' => $pendingId,
        ]);
        $contract = Contract::latest()->first();
        $this->generatePayments($contract);

        return redirect()->back()->with('success', 'Contract created successfully and is pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load(['student', 'room', 'payments']);

        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        return view('contracts.edit', [
            'contracts' => $contract,
            'students' => Student::all(),
            'rooms' => Room::all(),
            'billingPeriods' => BillingPeriod::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        if (Contract::hasOverlap(
            $contract->room_id,
            $validated['start_date'],
            $validated['end_date'],
            $contract->id
            // ignoring itself when checking for overlaps during update
        )) {
            return back()->withErrors(['room_id' => 'The room is already booked for the selected period']);
        }
        $contract->update($validated);

        return redirect()->route('contracts.index')->with('success', 'The contracts has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully');
    }

     /*
    |--------------------------------------------------------------------------
    | WORKING WITH PAYMENTS RELATED TO THE CONTRACT
    |--------------------------------------------------------------------------
    */
    private function generatePayments(Contract $contract)
    {
        $pendingPaymentStatus = PaymentStatus::where('code', 'pending')->value('id');
        $start = Carbon::parse($contract->start_date);
        $end = Carbon::parse($contract->end_date);
        $current = $start->copy();
        while ($current <= $end) {
            Payment::create([
                'contract_id' => $contract->id,
                'payment_status_id' => $pendingPaymentStatus,
                'expected_amount' => $contract->rent_amount,
                'paid_amount' => 0,
                'due_date' => $current->copy(),
            ]);
            // Monthly peroid for now
            $current->addMonth();
        }
    }
}
