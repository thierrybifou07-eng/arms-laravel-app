<?php

namespace App\Helpers;

use App\Models\Contract;
use App\Models\Room;

/**
 * Residence Helper - Utilities for residence/property management
 */
class ResidenceHelper
{
    /**
     * Calculate residence occupancy rate
     */
    public static function getOccupancyRate($residence): float
    {
        $totalRooms = $residence->floors()
            ->join('rooms', 'floors.id', '=', 'rooms.floor_id')
            ->count();

        if ($totalRooms === 0) {
            return 0;
        }

        $occupiedRooms = Contract::whereHas('room', function ($query) use ($residence) {
            $query->whereHas('floor', function ($q) use ($residence) {
                $q->where('building_id', $residence->buildings()->first()?->id);
            });
        })
            ->whereHas('status', function ($query) {
                $query->where('code', 'approved');
            })
            ->count();

        return ($occupiedRooms / $totalRooms) * 100;
    }

    /**
     * Get revenue for residence
     */
    public static function getMonthlyRevenue($residence, $month = null): float
    {
        $month = $month ?? now()->month;
        $year = now()->year;

        return $residence->buildings()
            ->join('floors', 'buildings.id', '=', 'floors.building_id')
            ->join('rooms', 'floors.id', '=', 'rooms.floor_id')
            ->join('contracts', 'rooms.id', '=', 'contracts.room_id')
            ->join('payments', 'contracts.id', '=', 'payments.contract_id')
            ->whereMonth('payments.payment_date', $month)
            ->whereYear('payments.payment_date', $year)
            ->sum('payments.paid_amount');
    }

    /**
     * Get available rooms count
     */
    public static function getAvailableRoomsCount($residence): int
    {
        $totalRooms = $residence->floors()
            ->join('rooms', 'floors.id', '=', 'rooms.floor_id')
            ->count();

        $occupiedRooms = Contract::whereHas('room', function ($query) use ($residence) {
            $query->whereHas('floor', function ($q) use ($residence) {
                $q->where('building_id', $residence->buildings()->first()?->id);
            });
        })
            ->whereHas('status', function ($query) {
                $query->where('code', 'approved');
            })
            ->count();

        return max(0, $totalRooms - $occupiedRooms);
    }

    /**
     * Get total capacity
     */
    public static function getTotalCapacity($residence): int
    {
        return (int) $residence->buildings()->sum('capacity');
    }

    /**
     * Get current occupancy count
     */
    public static function getCurrentOccupancy($residence): int
    {
        return Contract::whereHas('room', function ($query) use ($residence) {
            $query->whereHas('floor', function ($q) use ($residence) {
                $q->where('building_id', $residence->buildings()->first()?->id);
            });
        })
            ->whereHas('status', function ($query) {
                $query->where('code', 'approved');
            })
            ->count();
    }

    /**
     * Get expiring contracts count
     */
    public static function getExpiringContractsCount($residence, $daysAhead = 30): int
    {
        $endDate = now()->addDays($daysAhead)->format('Y-m-d');

        return Contract::whereHas('room', function ($query) use ($residence) {
            $query->whereHas('floor', function ($q) use ($residence) {
                $q->where('building_id', $residence->buildings()->first()?->id);
            });
        })
            ->whereHas('status', function ($query) {
                $query->where('code', 'approved');
            })
            ->where('end_date', '<=', $endDate)
            ->count();
    }

    /**
     * Get outstanding payments
     */
    public static function getOutstandingPayments($residence): float
    {
        return $residence->buildings()
            ->join('floors', 'buildings.id', '=', 'floors.building_id')
            ->join('rooms', 'floors.id', '=', 'rooms.floor_id')
            ->join('contracts', 'rooms.id', '=', 'contracts.room_id')
            ->join('payments', 'contracts.id', '=', 'payments.contract_id')
            ->whereHas('payments.status', function ($query) {
                $query->where('code', 'pending');
            })
            ->sum(\DB::raw('payments.expected_amount - payments.paid_amount'));
    }
}
