<?php

namespace App\Helpers;

use App\Models\ContractStatus;
use App\Models\PaymentStatus;
use App\Models\RoomStatus;

/**
 * Status Helper - Utilities for status handling
 */
class StatusHelper
{
    public const CONTRACT_PENDING = 'pending';
    public const CONTRACT_APPROVED = 'approved';
    public const CONTRACT_REJECTED = 'rejected';
    public const CONTRACT_CANCELLED = 'cancelled';
    public const CONTRACT_EXPIRED = 'expired';

    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_OVERDUE = 'overdue';
    public const PAYMENT_CANCELLED = 'cancelled';
    public const PAYMENT_VALIDATED = 'validated';

    public const ROOM_AVAILABLE = 'available';
    public const ROOM_OCCUPIED = 'occupied';
    public const ROOM_MAINTENANCE = 'maintenance';

    /**
     * Get contract status by code
     */
    public static function getContractStatusByCode(string $code): ?ContractStatus
    {
        return ContractStatus::where('code', $code)->first();
    }

    /**
     * Get payment status by code
     */
    public static function getPaymentStatusByCode(string $code): ?PaymentStatus
    {
        return PaymentStatus::where('code', $code)->first();
    }

    /**
     * Get room status by code
     */
    public static function getRoomStatusByCode(string $code): ?RoomStatus
    {
        return RoomStatus::where('code', $code)->first();
    }

    /**
     * Get status label (localized)
     */
    public static function getLabel(string $code, string $type = 'payment'): string
    {
        $labels = [
            'payment' => [
                'pending' => 'En attente',
                'paid' => 'Payé',
                'overdue' => 'En retard',
                'cancelled' => 'Annulé',
                'validated' => 'Validé',
            ],
            'contract' => [
                'pending' => 'En attente',
                'approved' => 'Approuvé',
                'rejected' => 'Rejeté',
                'cancelled' => 'Annulé',
                'expired' => 'Expiré',
            ],
            'room' => [
                'available' => 'Disponible',
                'occupied' => 'Occupé',
                'maintenance' => 'Maintenance',
            ],
        ];

        return $labels[$type][$code] ?? $code;
    }

    /**
     * Get status badge class (Bootstrap/Tailwind)
     */
    public static function getBadgeClass(string $code): string
    {
        return match ($code) {
            'pending' => 'badge-warning',
            'paid', 'approved', 'available', 'validated' => 'badge-success',
            'overdue', 'cancelled' => 'badge-danger',
            'rejected' => 'badge-danger',
            default => 'badge-info',
        };
    }

    /**
     * Get status icon
     */
    public static function getIcon(string $code): string
    {
        return match ($code) {
            'pending' => 'fas fa-hourglass-half',
            'paid', 'approved', 'available', 'validated' => 'fas fa-check-circle',
            'overdue' => 'fas fa-exclamation-circle',
            'cancelled' => 'fas fa-times-circle',
            'rejected' => 'fas fa-times-circle',
            default => 'fas fa-info-circle',
        };
    }

    /**
     * All contract statuses
     */
    public static function getAllContractStatuses(): array
    {
        return [
            self::CONTRACT_PENDING => 'En attente',
            self::CONTRACT_APPROVED => 'Approuvé',
            self::CONTRACT_REJECTED => 'Rejeté',
            self::CONTRACT_CANCELLED => 'Annulé',
            self::CONTRACT_EXPIRED => 'Expiré',
        ];
    }

    /**
     * All payment statuses
     */
    public static function getAllPaymentStatuses(): array
    {
        return [
            self::PAYMENT_PENDING => 'En attente',
            self::PAYMENT_PAID => 'Payé',
            self::PAYMENT_OVERDUE => 'En retard',
            self::PAYMENT_CANCELLED => 'Annulé',
            self::PAYMENT_VALIDATED => 'Validé',
        ];
    }
}
