<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\User;
use App\Models\Room;
use App\Models\ContractStatus;
use App\Models\BillingPeriod;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all student users
        $students = User::whereHas('roles', function ($q) {
            $q->where('code', 'student');
        })->get();

        $studentCount = 0;
        $contractsByStatus = [];

        foreach ($students as $student) {
            // Each student gets 1-3 contracts
            $contractCount = fake()->numberBetween(1, 3);
            
            for ($i = 0; $i < $contractCount; $i++) {
                $statusCodes = [
                    ContractStatus::PENDING,
                    ContractStatus::ACTIVE,
                    ContractStatus::OVERDUE,
                    ContractStatus::EXPIRED,
                    ContractStatus::ARCHIVED,
                    ContractStatus::CANCELLED,
                ];
                
                $statusCode = fake()->randomElement($statusCodes);
                $statusId = ContractStatus::where('code', $statusCode)->first()->id;

                // Get a random available room
                $room = Room::inRandomOrder()->first();
                if (!$room) {
                    continue;
                }

                // Create contract based on status
                if ($statusCode === ContractStatus::PENDING) {
                    $contract = Contract::factory()
                        ->pending()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === ContractStatus::ACTIVE) {
                    $contract = Contract::factory()
                        ->active()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === ContractStatus::OVERDUE) {
                    $contract = Contract::factory()
                        ->overdue()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === ContractStatus::EXPIRED) {
                    $contract = Contract::factory()
                        ->expired()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                } elseif ($statusCode === ContractStatus::ARCHIVED) {
                    $contract = Contract::factory()
                        ->archived()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                } else {
                    $contract = Contract::factory()
                        ->cancelled()
                        ->create([
                            'user_id' => $student->id,
                            'room_id' => $room->id,
                            'contract_status_id' => $statusId,
                        ]);
                }

                // Track status distribution
                if (!isset($contractsByStatus[$statusCode])) {
                    $contractsByStatus[$statusCode] = 0;
                }
                $contractsByStatus[$statusCode]++;
                $studentCount++;
            }
        }

        $this->command->info("✓ $studentCount contracts created with distribution:");
        foreach ($contractsByStatus as $status => $count) {
            $this->command->info("  - $status: $count");
        }
    }
}
