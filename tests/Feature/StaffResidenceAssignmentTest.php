<?php

use App\Models\BillingPeriod;
use App\Models\Building;
use App\Models\BuildingStatus;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Floor;
use App\Models\FloorStatus;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Residence;
use App\Models\ResidenceStatus;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\User;
use App\Models\UserStatus;

beforeEach(function () {
    UserStatus::create([
        'code' => UserStatus::ACTIVE,
        'label' => 'Active',
    ]);

    Role::insert([
        ['name' => Role::SUPER_ADMIN, 'label' => 'System Administrator', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::ADMIN, 'label' => 'Residence Manager', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STAFF, 'label' => 'Staff Member', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STUDENT, 'label' => 'Student', 'created_at' => now(), 'updated_at' => now()],
    ]);

    ResidenceStatus::create(['code' => 'open', 'label' => 'Open']);
    BuildingStatus::create(['code' => 'active', 'label' => 'Active']);
    FloorStatus::create(['code' => 'active', 'label' => 'Active']);
    RoomStatus::insert([
        ['code' => 'available', 'label' => 'Available', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'busy', 'label' => 'Busy', 'created_at' => now(), 'updated_at' => now()],
    ]);
    ContractStatus::insert([
        ['code' => 'pending', 'label' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'active', 'label' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'overdue', 'label' => 'Overdue', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'expired', 'label' => 'Expired', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'archived', 'label' => 'Archived', 'created_at' => now(), 'updated_at' => now()],
    ]);
    PaymentStatus::insert([
        ['code' => 'pending', 'label' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'processing', 'label' => 'Processing', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'validated', 'label' => 'Validated', 'created_at' => now(), 'updated_at' => now()],
        ['code' => 'cancelled', 'label' => 'Cancelled', 'created_at' => now(), 'updated_at' => now()],
    ]);
    BillingPeriod::create(['code' => 'monthly', 'label' => 'Monthly', 'days' => '30']);
    PaymentMethod::create(['code' => 'cash', 'label' => 'Cash']);
});

function makeScopedUser(string $roleName, array $attributes = []): User
{
    $user = User::factory()->create(array_merge([
        'user_status_id' => UserStatus::where('code', UserStatus::ACTIVE)->value('id'),
        'email_verified_at' => now(),
    ], $attributes));

    $user->roles()->sync([Role::where('name', $roleName)->value('id')]);

    return $user;
}

function createResidenceTree(string $suffix): array
{
    $residence = Residence::create([
        'residence_status_id' => ResidenceStatus::where('code', 'open')->value('id'),
        'name' => "Residence {$suffix}",
        'city' => 'Douala',
        'address' => "Address {$suffix}",
        'capacity' => 10,
    ]);

    $building = Building::create([
        'residence_id' => $residence->id,
        'building_status_id' => BuildingStatus::where('code', 'active')->value('id'),
        'name' => "Building {$suffix}",
        'address' => "Building address {$suffix}",
        'capacity' => 10,
    ]);

    $floor = Floor::create([
        'building_id' => $building->id,
        'floor_status_id' => FloorStatus::where('code', 'active')->value('id'),
        'number' => 1,
        'capacity' => 10,
    ]);

    $room = Room::create([
        'floor_id' => $floor->id,
        'room_status_id' => RoomStatus::where('code', 'busy')->value('id'),
        'number' => "R-{$suffix}",
        'rent' => 150000,
    ]);

    return compact('residence', 'building', 'floor', 'room');
}

function createContractForRoom(User $student, Room $room): Contract
{
    return Contract::create([
        'user_id' => $student->id,
        'room_id' => $room->id,
        'contract_status_id' => ContractStatus::where('code', 'active')->value('id'),
        'billing_period_id' => BillingPeriod::where('code', 'monthly')->value('id'),
        'rent_amount' => $room->rent,
        'start_date' => now()->startOfDay(),
        'end_date' => now()->addMonth()->startOfDay(),
    ]);
}

function createPaymentForContract(Contract $contract, string $statusCode = 'validated'): Payment
{
    $isValidated = $statusCode === 'validated';

    return Payment::create([
        'contract_id' => $contract->id,
        'payment_method_id' => PaymentMethod::where('code', 'cash')->value('id'),
        'payment_status_id' => PaymentStatus::where('code', $statusCode)->value('id'),
        'expected_amount' => $contract->rent_amount,
        'paid_amount' => $isValidated ? $contract->rent_amount : 0,
        'payment_date' => $isValidated ? now() : null,
        'due_date' => now()->startOfDay(),
    ]);
}

it('requires a residence when assigning the staff role', function () {
    $admin = makeScopedUser(Role::ADMIN, ['firstname' => 'Assignor']);
    $target = makeScopedUser(Role::STUDENT, ['firstname' => 'Target']);

    $response = $this
        ->actingAs($admin)
        ->from(route('super_admin.user.roles.edit', $target))
        ->put(route('super_admin.user.roles.update', $target), [
            'role' => Role::where('name', Role::STAFF)->value('id'),
        ]);

    $response
        ->assertRedirect(route('super_admin.user.roles.edit', $target))
        ->assertSessionHasErrors('residence_id');

    expect($target->fresh()->getRoleName())->toBe(Role::STUDENT);
});

it('syncs exactly one residence when assigning the staff role', function () {
    $admin = makeScopedUser(Role::ADMIN, ['firstname' => 'Assignor']);
    $target = makeScopedUser(Role::STUDENT, ['firstname' => 'Target']);
    $firstResidence = createResidenceTree('Alpha')['residence'];
    $secondResidence = createResidenceTree('Beta')['residence'];

    $target->residences()->sync([$firstResidence->id]);

    $this
        ->actingAs($admin)
        ->put(route('super_admin.user.roles.update', $target), [
            'role' => Role::where('name', Role::STAFF)->value('id'),
            'residence_id' => $secondResidence->id,
        ])
        ->assertRedirect(route('users.show', $target));

    expect($target->fresh()->getRoleName())->toBe(Role::STAFF);
    expect($target->fresh()->residences->pluck('id')->all())->toBe([$secondResidence->id]);
});

it('assigns newly created residences to every admin automatically', function () {
    $firstAdmin = makeScopedUser(Role::ADMIN, ['firstname' => 'FirstAdmin']);
    $secondAdmin = makeScopedUser(Role::ADMIN, ['firstname' => 'SecondAdmin']);
    $staff = makeScopedUser(Role::STAFF, ['firstname' => 'Staff']);

    $residence = Residence::create([
        'residence_status_id' => ResidenceStatus::where('code', 'open')->value('id'),
        'name' => 'Residence Auto Linked',
        'city' => 'Douala',
        'address' => 'Auto linked address',
        'capacity' => 20,
    ]);

    expect($firstAdmin->fresh()->residences->pluck('id')->all())->toBe([$residence->id]);
    expect($secondAdmin->fresh()->residences->pluck('id')->all())->toBe([$residence->id]);
    expect($staff->fresh()->residences)->toHaveCount(0);
});

it('limits staff contract, payment and history listings to the assigned residence', function () {
    $staff = makeScopedUser(Role::STAFF, ['firstname' => 'Scoped', 'lastname' => 'Staff']);
    $residentOne = makeScopedUser(Role::STUDENT, ['firstname' => 'ScopedResident', 'lastname' => 'One']);
    $residentTwo = makeScopedUser(Role::STUDENT, ['firstname' => 'ForeignResident', 'lastname' => 'Two']);

    $alpha = createResidenceTree('Alpha');
    $beta = createResidenceTree('Beta');

    $staff->residences()->sync([$alpha['residence']->id]);

    $contractOne = createContractForRoom($residentOne, $alpha['room']);
    $contractTwo = createContractForRoom($residentTwo, $beta['room']);

    $paymentOne = createPaymentForContract($contractOne);
    $paymentTwo = createPaymentForContract($contractTwo);

    PaymentHistory::create([
        'payment_id' => $paymentOne->id,
        'amount' => $paymentOne->paid_amount,
        'old_balance' => 0,
        'new_balance' => $paymentOne->paid_amount,
        'recorded_by' => $staff->id,
        'notes' => 'Alpha history',
    ]);

    PaymentHistory::create([
        'payment_id' => $paymentTwo->id,
        'amount' => $paymentTwo->paid_amount,
        'old_balance' => 0,
        'new_balance' => $paymentTwo->paid_amount,
        'recorded_by' => $staff->id,
        'notes' => 'Beta history',
    ]);

    $this->actingAs($staff)
        ->get(route('contracts.index'))
        ->assertOk()
        ->assertSee('ScopedResident One')
        ->assertDontSee('ForeignResident Two');

    $this->actingAs($staff)
        ->get(route('payments.index'))
        ->assertOk()
        ->assertSee('ScopedResident One')
        ->assertDontSee('ForeignResident Two');

    $this->actingAs($staff)
        ->get(route('payment_histories.index'))
        ->assertOk()
        ->assertSee('ScopedResident')
        ->assertDontSee('ForeignResident');
});

it('shows dashboard data only for the staff assigned residence', function () {
    $staff = makeScopedUser(Role::STAFF, ['firstname' => 'Scoped', 'lastname' => 'Staff']);
    $residentOne = makeScopedUser(Role::STUDENT, ['firstname' => 'ScopedResident', 'lastname' => 'One']);
    $residentTwo = makeScopedUser(Role::STUDENT, ['firstname' => 'ForeignResident', 'lastname' => 'Two']);

    $alpha = createResidenceTree('Alpha');
    $beta = createResidenceTree('Beta');

    $staff->residences()->sync([$alpha['residence']->id]);

    $contractOne = createContractForRoom($residentOne, $alpha['room']);
    $contractTwo = createContractForRoom($residentTwo, $beta['room']);

    createPaymentForContract($contractOne);
    createPaymentForContract($contractTwo);

    $this->actingAs($staff)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Residence Alpha')
        ->assertSee('ScopedResident')
        ->assertDontSee('ForeignResident');
});
