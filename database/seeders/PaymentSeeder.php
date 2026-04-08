<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Contract;
use App\Models\PaymentStatus;
use App\Models\EventPaymentType;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all contracts
        $contracts = Contract::all();

        $paymentsByStatus = [];
        $paymentCount = 0;
        $paymentHistoryCount = 0;

        foreach ($contracts as $contract) {
            // Each contract gets 2-6 payments
            $paymentCount_contract = fake()->numberBetween(2, 6);
            
            for ($i = 0; $i < $paymentCount_contract; $i++) {
                $statusCodes = [
                    PaymentStatus::PENDING,
                    PaymentStatus::PROCESSING,
                    PaymentStatus::VALIDATED,
                    PaymentStatus::CANCELLED,
                ];
                
                $statusCode = fake()->randomElement($statusCodes);
                $statusId = PaymentStatus::where('code', $statusCode)->first()->id;

                // Create payment based on status
                if ($statusCode === PaymentStatus::PENDING) {
                    $payment = Payment::factory()
                        ->pending()
                        ->create([
                            'contract_id' => $contract->id,
                            'payment_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === PaymentStatus::PROCESSING) {
                    $payment = Payment::factory()
                        ->processing()
                        ->create([
                            'contract_id' => $contract->id,
                            'payment_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === PaymentStatus::VALIDATED) {
                    $payment = Payment::factory()
                        ->validated()
                        ->create([
                            'contract_id' => $contract->id,
                            'payment_status_id' => $statusId,
                        ]);
                } else {
                    $payment = Payment::factory()
                        ->cancelled()
                        ->create([
                            'contract_id' => $contract->id,
                            'payment_status_id' => $statusId,
                        ]);
                }

                // Track status distribution
                if (!isset($paymentsByStatus[$statusCode])) {
                    $paymentsByStatus[$statusCode] = 0;
                }
                $paymentsByStatus[$statusCode]++;
                $paymentCount++;

                // Create 1-3 payment histories per payment
                $historyCount = fake()->numberBetween(1, 3);
                for ($h = 0; $h < $historyCount; $h++) {
                    PaymentHistory::factory()->create([
                        'payment_id' => $payment->id,
                        'recorded_by' => fake()->numberBetween(1, 41), // 1 super + 5 admin + 15 staff + 20 teller
                    ]);
                    $paymentHistoryCount++;
                }
            }
        }

        $this->command->info("✓ $paymentCount payments created with distribution:");
        foreach ($paymentsByStatus as $status => $count) {
            $this->command->info("  - $status: $count");
        }

        $this->command->info("✓ $paymentHistoryCount payment histories created");
    }
}
