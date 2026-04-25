<?php

use App\Models\Contract;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    config()->set('audit.enabled', false);
});

it('stores the sum of linked payment expected amounts in contract_amount', function () {
    $residenceStatusId = DB::table('residence_statuses')->insertGetId([
        'code' => 'active',
        'label' => 'Active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $buildingStatusId = DB::table('building_statuses')->insertGetId([
        'code' => 'active',
        'label' => 'Active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $floorStatusId = DB::table('floor_statuses')->insertGetId([
        'code' => 'active',
        'label' => 'Active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $roomStatusId = DB::table('room_statuses')->insertGetId([
        'code' => 'available',
        'label' => 'Available',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $contractStatusId = DB::table('contract_statuses')->insertGetId([
        'code' => 'pending',
        'label' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $paymentStatusId = DB::table('payment_statuses')->insertGetId([
        'code' => 'pending',
        'label' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $billingPeriodId = DB::table('billing_periods')->insertGetId([
        'code' => 'monthly',
        'label' => 'Monthly',
        'days' => '30',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $residenceId = DB::table('residences')->insertGetId([
        'residence_status_id' => $residenceStatusId,
        'name' => 'Residence A',
        'city' => 'Douala',
        'address' => 'Main street',
        'capacity' => 100,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $buildingId = DB::table('buildings')->insertGetId([
        'residence_id' => $residenceId,
        'building_status_id' => $buildingStatusId,
        'name' => 'Building A',
        'address' => 'Main street',
        'capacity' => 40,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $floorId = DB::table('floors')->insertGetId([
        'building_id' => $buildingId,
        'floor_status_id' => $floorStatusId,
        'number' => 1,
        'capacity' => 20,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $roomId = DB::table('rooms')->insertGetId([
        'floor_id' => $floorId,
        'room_status_id' => $roomStatusId,
        'number' => '101',
        'rent' => 50000,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $contract = Contract::create([
        'user_id' => null,
        'room_id' => $roomId,
        'contract_status_id' => $contractStatusId,
        'billing_period_id' => $billingPeriodId,
        'rent_amount' => 50000,
        'contract_amount' => 0,
        'start_date' => '2026-04-01',
        'end_date' => '2026-06-30',
    ]);

    $firstPayment = Payment::create([
        'contract_id' => $contract->id,
        'payment_status_id' => $paymentStatusId,
        'payment_method_id' => null,
        'expected_amount' => 50000,
        'paid_amount' => 0,
        'payment_date' => null,
        'due_date' => '2026-04-01',
    ]);

    expect($contract->fresh()->contract_amount)->toBe('50000.00');

    $secondPayment = Payment::create([
        'contract_id' => $contract->id,
        'payment_status_id' => $paymentStatusId,
        'payment_method_id' => null,
        'expected_amount' => 75000,
        'paid_amount' => 0,
        'payment_date' => null,
        'due_date' => '2026-05-01',
    ]);

    expect($contract->fresh()->contract_amount)->toBe('125000.00');

    $secondPayment->update([
        'expected_amount' => 80000,
    ]);

    expect($contract->fresh()->contract_amount)->toBe('130000.00');

    $firstPayment->delete();

    expect($contract->fresh()->contract_amount)->toBe('80000.00');
});
