<?php

namespace Database\Seeders;

use App\Models\PaymentReceipt;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all validated payments
        $validatedPayments = Payment::whereHas('status', function ($q) {
            $q->where('code', 'validated');
        })->get();

        $receiptCount = 0;

        foreach ($validatedPayments as $payment) {
            // Each validated payment may have 0-2 receipts (some payments split into multiple receipts)
            if (fake()->boolean(70)) {
                $receiptCount_payment = fake()->numberBetween(1, 2);
                
                for ($i = 0; $i < $receiptCount_payment; $i++) {
                    $receiptAmount = $payment->paid_amount / $receiptCount_payment;
                    
                    PaymentReceipt::create([
                        'payment_id' => $payment->id,
                        'amount' => $receiptAmount,
                        'number' => 'RCP-' . date('Y') . '-' . str_pad($receiptCount + 1, 8, '0', STR_PAD_LEFT),
                        'issue_date' => $payment->payment_date ?? now(),
                        'file_path' => '/storage/receipts/receipt-' . $payment->id . '-' . ($i + 1) . '.pdf',
                    ]);
                    $receiptCount++;
                }
            }
        }

        $this->command->info("✓ $receiptCount payment receipts created");
    }
}
