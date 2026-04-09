<?php

namespace App\Services;

use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Database\Eloquent\Collection;

/**
 * Billing Service - Handles billing period management and payment generation
 */
class BillingService
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create a billing period
     */
    public function createBillingPeriod(array $data): BillingPeriod
    {
        return BillingPeriod::create($data);
    }

    /**
     * Activate a billing period
     */
    public function activateBillingPeriod(BillingPeriod $billingPeriod): BillingPeriod
    {
        $billingPeriod->update(['is_active' => true]);
        return $billingPeriod;
    }

    /**
     * Close a billing period
     */
    public function closeBillingPeriod(BillingPeriod $billingPeriod): BillingPeriod
    {
        $billingPeriod->update(['is_active' => false]);
        return $billingPeriod;
    }

    /**
     * Generate payments for a billing period
     */
    public function generatePaymentsForPeriod(BillingPeriod $billingPeriod): int
    {
        $contracts = Contract::whereHas('status', function ($query) {
            $query->where('code', 'active');
        })
            ->where('billing_period_id', $billingPeriod->id)
            ->get();

        $pendingStatus = PaymentStatus::where('code', 'pending')->first();
        $defaultPaymentMethod = \App\Models\PaymentMethod::first();

        $count = 0;

        foreach ($contracts as $contract) {
            // Check if payment already exists for this contract and period
            $existingPayment = Payment::where('contract_id', $contract->id)
                ->where('billing_period_id', $billingPeriod->id)
                ->exists();

            if (!$existingPayment) {
                Payment::create([
                    'contract_id' => $contract->id,
                    'payment_method_id' => $defaultPaymentMethod->id,
                    'payment_status_id' => $pendingStatus->id,
                    'expected_amount' => $contract->monthly_amount,
                    'paid_amount' => 0,
/*                     'tip_amount' => 0,
 */                    'payment_date' => now(),
                    'due_date' => now()->addDays(30),
                    'billing_period_id' => $billingPeriod->id,
                ]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get billing period statistics
     */
    public function getBillingPeriodStats(BillingPeriod $billingPeriod): array
    {
        $payments = $billingPeriod->payments;

        return [
            'total_payments' => $payments->count(),
            'total_expected' => $payments->sum('expected_amount'),
            'total_paid' => $payments->sum('paid_amount'),
            'total_outstanding' => $payments->sum(function ($p) {
                return $p->expected_amount - $p->paid_amount;
            }),
            'pending_count' => $payments->filter(function ($p) {
                return $p->status->code === 'pending';
            })->count(),
            'paid_count' => $payments->filter(function ($p) {
                return $p->status->code === 'paid';
            })->count(),
            'overdue_count' => $payments->filter(function ($p) {
                return $p->isOverdue();
            })->count(),
        ];
    }

    /**
     * Get active billing periods
     */
    public function getActiveBillingPeriods(): Collection
    {
        return BillingPeriod::where('is_active', true)
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    /**
     * Get all billing periods
     */
    public function getAllBillingPeriods(): Collection
    {
        return BillingPeriod::orderBy('start_date', 'DESC')->get();
    }
}
