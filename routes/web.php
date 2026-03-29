<?php

use App\Http\Controllers\Admin\PendingUserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\BillingPeriodController;
use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EventPaymentTypeController;
use App\Http\Controllers\FloorRoomController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceBuildingController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
Past route for the super administrator
*/
Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->prefix('super-admin')->name('super_admin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('user.roles.edit');
    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('user.roles.update');
});
Route::middleware(['auth', 'verified', 'checkRole:admin'])->prefix('activate-account')->name('activate_account')->group(function () {
    Route::get('pending-users/{user}/edit', [PendingUserController::class, 'edit'])->name('pending_users.edit');
    Route::put('pending-users/{user}', [PendingUserController::class, 'update'])->name('pending_users.update');
    Route::get('pending-users', [PendingUserController::class, 'index'])->name('pending_users.index');
    Route::get('pending-users/{user}', [PendingUserController::class, 'show'])->name('pending_users.show');
});
/*
Past route for the creation of contrac
*/
Route::get('/buildings/{residence}', [ContractController::class, 'getBuildings']);
Route::get('/floors/{building}', [ContractController::class, 'getFloors']);
Route::get('/rooms/{floor}', [ContractController::class, 'getRooms']);
Route::get('/super_admin/dashboard', function () {
    return view('super_admin.dashboard');
})->middleware(['auth', 'verified', 'checkRole:super_admin'])->name('super_admin.dashboard');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/view', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/avatar', [ProfileController::class, 'updateAvatar'])
        ->name('avatar.update');
});
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('residences', ResidenceController::class)->scoped();
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('residences.buildings', ResidenceBuildingController::class)->scoped();
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('buildings.floors', BuildingFloorController::class)->scoped();

Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('floors.rooms', FloorRoomController::class)->scoped();
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('contracts', ContractController::class)->scoped();

Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('users', UserController::class)->only(['index', 'show', 'update', 'destroy'])->scoped();
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('roles', RoleController::class)->scoped();
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('permissions', PermissionController::class)->scoped();

// Student management routes
Route::middleware(['auth', 'verified', 'checkRole:staff,admin,super_admin'])->resource('students', StudentController::class)->scoped();

// Billing period routes
Route::middleware(['auth', 'verified', 'checkRole:staff,admin,super_admin'])->resource('billing_periods', BillingPeriodController::class)->scoped();

// Payment method routes
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('payment_methods', PaymentMethodController::class)->scoped();

// Payment status routes  
Route::middleware(['auth', 'verified', 'checkRole:super_admin'])->resource('payment_statuses', PaymentStatusController::class)->scoped();

// Event payment type routes
Route::middleware(['auth', 'verified', 'checkRole:staff,admin,super_admin'])->resource('event_payment_types', EventPaymentTypeController::class)->scoped();

// Payment history routes
Route::middleware(['auth', 'verified', 'checkRole:staff,teller,admin,super_admin'])->group(function () {
    Route::resource('payment_histories', PaymentHistoryController::class)->scoped();
    Route::post('payment_histories/export', [PaymentHistoryController::class, 'export'])->name('payment_histories.export');
});

Route::middleware('auth')->group(function () {
    Route::resource('payments', PaymentController::class)->only('index');
    Route::get('/payments/{payment}', [PaymentController::class, 'payForm'])->name('payments.pay.form');
    Route::get('/payments/{payment}/pay', [PaymentController::class, 'showPay'])->name('payments.show.pay');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
    Route::post('/payments/{payment}/validate', [PaymentController::class, 'validatePayment'])->name('payments.validate');
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

    /*     Route::patch('/contracts/{contract}/archived', ContractController::class, 'archived')->name('contracts.archive');
     */
});
require __DIR__.'/auth.php';
