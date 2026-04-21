<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Contract Service - Handles contract lifecycle management
 */
class ContractService
{
    /**
     * Create a contract
     */
    public function createContract(array $data): Contract
    {
        return Contract::create($data);
    }

    /**
     * Update a contract
     */
    public function updateContract(Contract $contract, array $data): Contract
    {
        $contract->update($data);
        return $contract;
    }

    /**
     * Approve a contract
     */
    public function approveContract(Contract $contract): Contract
    {
        $approvedStatus = ContractStatus::where('code', 'approved')->first();
        $contract->update(['contract_status_id' => $approvedStatus->id]);
        return $contract;
    }

    /**
     * Reject a contract
     */
    public function rejectContract(Contract $contract, string $reason = ''): Contract
    {
        $rejectedStatus = ContractStatus::where('code', 'rejected')->first();
        $contract->update(['contract_status_id' => $rejectedStatus->id]);
        return $contract;
    }

    /**
     * Cancel a contract
     */
    public function cancelContract(Contract $contract): Contract
    {
        $cancelledStatus = ContractStatus::where('code', 'cancelled')->first();
        $contract->update(['contract_status_id' => $cancelledStatus->id]);
        return $contract;
    }

    /**
     * Renew a contract
     */
    public function renewContract(Contract $contract, array $newDates): Contract
    {
        $newContract = Contract::create([
            'user_id' => $contract->user_id,
            'room_id' => $contract->room_id,
            'contract_status_id' => ContractStatus::where('code', 'pending')->first()->id,
            'billing_period_id' => $contract->billing_period_id,
            'rent_amount' => $newDates['rent_amount'] ?? $contract->rent_amount,
            'start_date' => $newDates['start_date'],
            'end_date' => $newDates['end_date'],
        ]);

        return $newContract;
    }

    /**
     * Get active contracts for a user
     */
    public function getActiveContractsForUser(User $user): Collection
    {
        return $user->contracts()
            ->whereHas('status', function ($query) {
                $query->where('code', 'active');
            })
            ->with('room', 'status')
            ->get();
    }

    /**
     * Get contracts by room
     */
    public function getContractsByRoom(Room $room): Collection
    {
        return $room->contracts()
            ->with('user', 'status')
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    /**
     * Check if room is available
     */
    public function isRoomAvailable(Room $room, $startDate, $endDate): bool
    {
        $conflicts = $room->contracts()
            ->whereHas('status', function ($query) {
                $query->whereIn('code', ['pending', 'active']);
            })
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->count();

        return $conflicts === 0;
    }

    /**
     * Get expiring contracts
     */
    public function getExpiringContracts($daysAhead = 30): Collection
    {
        $endDate = now()->addDays($daysAhead)->format('Y-m-d');

        return Contract::whereHas('status', function ($query) {
            $query->where('code', 'approved');
        })
            ->where('end_date', '<=', $endDate)
            ->with('student', 'room')
            ->get();
    }

    /**
     * Get contract statistics
     */
    public function getContractStats(): array
    {
        return [
            'total_contracts' => Contract::count(),
            'approved_contracts' => Contract::whereHas('status', function ($q) {
                $q->where('code', 'approved');
            })->count(),
            'pending_contracts' => Contract::whereHas('status', function ($q) {
                $q->where('code', 'pending');
            })->count(),
            'rejected_contracts' => Contract::whereHas('status', function ($q) {
                $q->where('code', 'rejected');
            })->count(),
            'total_value' => Contract::sum('monthly_amount'),
        ];
    }
}
