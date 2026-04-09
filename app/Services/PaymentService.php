<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Payment Service - Handles all payment-related business logic
 */
class PaymentService
{
    /**
     * Create a payment
     */
    public function createPayment(array $data): Payment
    {
        return Payment::create($data);
    }

    /**
     * Update a payment
     */
    public function updatePayment(Payment $payment, array $data): Payment
    {
        $payment->update($data);
        return $payment;
    }

    /**
     * Validate payment
     */
    public function validatePayment(Payment $payment): bool
    {
        if (!$payment->canBeValidated()) {
            return false;
        }

        $validatedStatus = PaymentStatus::where('code', 'validated')->first();
        $payment->update(['payment_status_id' => $validatedStatus->id]);

        return true;
    }

    /**
     * Cancel payment
     */
    public function cancelPayment(Payment $payment, string $reason = ''): bool
    {
        $cancelledStatus = PaymentStatus::where('code', 'cancelled')->first();
        $payment->update([
            'payment_status_id' => $cancelledStatus->id,
        ]);

        return true;
    }

    /**
     * Process payment - mark as paid
     */
    public function processPayment(Payment $payment, array $data): Payment
    {
        $paidStatus = PaymentStatus::where('code', 'paid')->first();
        
        $payment->update([
            'payment_status_id' => $paidStatus->id,
            'paid_amount' => $data['paid_amount'] ?? $payment->expected_amount,
/*             'tip_amount' => $data['tip_amount'] ?? 0,
 */            'payment_date' => $data['payment_date'] ?? now(),
        ]);

        return $payment;
    }

    /**
     * Get overdue payments
     */
    public function getOverduePayments(): Collection
    {
        return Payment::whereHas('status', function ($query) {
            $query->whereNotIn('code', ['validated', 'cancelled', 'paid']);
        })
            ->where('due_date', '<', now())
            ->get();
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {
        $query = Payment::query();

        if ($startDate) {
            $query->where('payment_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('payment_date', '<=', $endDate);
        }

        return [
            'total_payments' => $query->count(),
            'total_amount' => $query->sum('paid_amount'),
            'average_payment' => $query->avg('paid_amount'),
/*             'total_tips' => $query->sum('tip_amount'),
 */            'pending_count' => $query->whereHas('status', function ($q) {
                $q->where('code', 'pending');
            })->count(),
        ];
    }

    /**
     * Check if payment is overdue
     */
    public function isOverdue(Payment $payment): bool
    {
        return $payment->isOverdue();
    }

    /**
     * Get payment by contract
     */
    public function getPaymentsByContract($contractId): Collection
    {
        return Payment::where('contract_id', $contractId)
            ->with('status', 'method')
            ->orderBy('due_date', 'DESC')
            ->get();
    }

    /**
     * Calculate payment schedule for a contract
     */
    public function generatePaymentSchedule($contract, $billingPeriod): array
    {
        $payments = [];
        $startDate = Carbon::parse($billingPeriod->start_date);
        $endDate = Carbon::parse($billingPeriod->end_date);
        
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $payments[] = [
                'contract_id' => $contract->id,
                'expected_amount' => $contract->monthly_amount,
                'payment_date' => $currentDate->copy(),
                'due_date' => $currentDate->copy()->addDays(5), // 5 days grace period
            ];
            $currentDate->addMonth();
        }

        return $payments;
    }
}
