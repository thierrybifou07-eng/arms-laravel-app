<?php

namespace App\Http\Controllers;

use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function getBuildings($residenceId)
    {
        return \App\Models\Building::where('residence_id', $residenceId)->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Contract::with(['user', 'room.floor.building', 'status', 'billingPeriod'])->latest();

        // Hide archived contracts unless user is admin or super_admin
        if (! auth()->user()->hasRole('admin') && ! auth()->user()->hasRole('super_admin')) {
            $archivedId = ContractStatus::getIdByCodeOrFail('archived');
            $query->where('contract_status_id', '!=', $archivedId);
        }

        // Apply status filter before pagination
        if (request('status') && request('status') !== '') {
            $status = request('status');
            if ($status === 'overdue') {
                // Filter for overdue payments logic
                $query->whereIn('contract_status_id', [
                    ContractStatus::where('code', 'overdue')->value('id'),
                ]);
            } else {
                $query->whereHas('status', fn ($q) => $q->where('code', $status));
            }
        }

        // Apply search filter
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('firstname', 'like', "%$search%")
                    ->orWhere('lastname', 'like', "%$search%")
                    /*  ->orWhere('email', 'like', "%$search%") */
                )
                    ->orWhereHas('room', fn ($r) => $r->where('number', 'like', "%$search%")
                      ->orWhere('rent_amount', 'like', "%$search%")
                    );
            });
        }

        $contracts = $query->paginate(10)->withQueryString();

        return view('contracts.index', compact('contracts'));
    }

    public function getFloors($buildingId)
    {
        return \App\Models\Floor::where('building_id', $buildingId)->get();
    }

    public function getRooms($floorId)
    {
        return \App\Models\Room::where('floor_id', $floorId)
            ->whereHas('status', fn ($q) => $q->where('code', 'available')) //  typo into the DB
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contracts.create', [
            'students' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->get(),
            'rooms' => Room::whereHas('status', fn ($q) => $q->where('code', 'available'))->get(),
            'billingPeriods' => BillingPeriod::all(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'billing_period_id' => 'required|exists:billing_periods,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        // checking overlapping contracts for the same room
        if (Contract::hasOverlap(
            $validated['room_id'],
            $validated['start_date'],
            $validated['end_date'],
        )) {
            return back()->withErrors(['room_id' => 'The room is already booked for the selected period.']);

        }
        // bring Id of contract status
        $pendingId = ContractStatus::getIdByCodeOrFail('pending');
        // bring the room rent
        $room = Room::with('status')->findOrFail($validated['room_id']);
        if ($room->status->code !== 'available') {
            return back()->withErrors(['room_id' => 'Room not available']);
        }
        // Update room status to 'busy'
        $busyId = \App\Models\RoomStatus::where('code', 'busy')->value('id');
        DB::transaction(function () use ($validated, $room, $pendingId, $busyId) {
            $contract = Contract::create([
                ...$validated,
                'rent_amount' => $room->rent,
                'contract_status_id' => $pendingId,
            ]);

            $room->update([
                'room_status_id' => $busyId,
            ]);

            if ($contract->status->code === 'pending') {
                $this->generatePayments($contract);
            }
        });

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully and waiting for payment.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load(['user', 'room', 'payments']);

        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        // Prevent editing expired contracts
        if ($contract->status->code === 'expired' || $contract->status->code === 'archived') {
            return redirect()->route('contracts.show', $contract)
                ->withErrors(['contract' => 'Expired or archived contracts cannot be edited.']);
        }

        return view('contracts.edit', [
            'contract' => $contract,
            'students' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->get(),
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
        $oldStatus = $contract->status->code;

        $contract->update($validated);

        if ($oldStatus !== 'active' && $contract->status->code === 'active') {
            $this->generatePayments($contract);
        }

        return redirect()->route('contracts.index')->with('success', 'The contracts has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function archived(Contract $contract)
    {
        if ($contract->status->code === 'active') {
            return back()->withErrors(['contract' => 'Active contracts cannot be archived directly. Cancelled or expire it first.']);
        }

        $archivedId = ContractStatus::getIdByCodeOrFail('archived');

        $contract->update([
            'contract_status_id' => $archivedId,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Contract archived successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | WORKING WITH PAYMENTS RELATED TO THE CONTRACT
    |--------------------------------------------------------------------------
    */
    private function generatePayments(Contract $contract)
    {
        if ($contract->payments()->exists()) {
            return;
        }

        $pendingStatus = PaymentStatus::getIdByCodeOrFail('pending');

        $start = Carbon::parse($contract->start_date);
        $end = Carbon::parse($contract->end_date);
        $period = $contract->billingPeriod->code;

        //  deduce delay in months (strong)
        $totalMonths = $start->diffInMonths($end) + 1;

        //  CASE 1 : unique payment
        if ($period === 'once') {

            $months = $start->diffInMonths($end) + 1;
            $total = $months * $contract->rent_amount;

            Payment::create([
                'contract_id' => $contract->id,
                'payment_status_id' => $pendingStatus,
                'expected_amount' => $total,
                'payment_method_id' => null,
                'payment_date' => null,
                'paid_amount' => 0,
                'due_date' => $start,
            ]);

            return;
        }

        // INTERVAL + MULTIPLIER
        $interval = match ($period) {
            'monthly' => 1,
            'quarterly' => 3,
            'half_yearly' => 6,
            'yearly' => 12,
            default => 1
        };

        $amountPerPayment = $contract->rent_amount * $interval;

        $current = $start->copy();

        while ($current < $end) {

            Payment::create([
                'contract_id' => $contract->id,
                'payment_status_id' => $pendingStatus,
                'expected_amount' => $amountPerPayment,
                'payment_method_id' => null,
                'payment_date' => null,
                'paid_amount' => 0,
                'due_date' => $current->copy(),
            ]);

            $current->addMonths($interval);
        }
    }
}
