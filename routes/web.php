<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\PendingUserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventPaymentTypeController;
use App\Http\Controllers\FloorRoomController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceBuildingController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|-----------------------------------------------------------------------
| Public route
|-----------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|-----------------------------------------------------------------------
| Common middleware stacks
|-----------------------------------------------------------------------
*/
$authVerifiedStatus = ['auth', 'verified', 'checkUserStatus'];
$superAdminOnly = ['auth', 'verified', 'checkUserStatus', 'checkRole:super_admin'];
$adminOnly = ['auth', 'verified', 'checkUserStatus', 'checkRole:admin'];
$superAdminAdmin = ['auth', 'verified', 'checkUserStatus', 'checkRole:super_admin,admin'];
$adminStaffOnly = ['auth', 'verified', 'checkUserStatus', 'checkRole:admin,staff'];
$student = ['auth', 'verified', 'checkUserStatus', 'checkRole:student'];
$paymentAccess = ['auth', 'verified', 'checkUserStatus', 'checkRole:staff,admin,student'];
$every = ['auth', 'verified', 'checkUserStatus', 'checkRole:super_admin,staff,admin,student'];
$profileAccess = ['auth', 'verified', 'checkUserStatus', 'checkRole:student,super_admin,staff,admin'];
$eventPaymentTypeAccess = ['auth', 'verified', 'checkUserStatus', 'checkRole:staff,admin'];

/*
|-----------------------------------------------------------------------
| Super administrator routes
|-----------------------------------------------------------------------
*/
Route::middleware($superAdminOnly)
    ->prefix('super-admin')
    ->name('super_admin')
    ->group(function () {
        // Audit logs routes
        Route::get('audits', [AuditController::class, 'index'])->name('audits.index');
        Route::get('audits/{audit}', [AuditController::class, 'show'])->name('audits.show');
        Route::delete('audits/{audit}', [AuditController::class, 'destroy'])->name('audits.destroy');
        Route::post('audits/delete-multiple', [AuditController::class, 'destroyMultiple'])->name('audits.destroyMultiple');
        Route::post('audits/export', [AuditController::class, 'export'])->name('audits.export');
    });
Route::middleware($superAdminAdmin)
    ->prefix('super-admin')
    ->name('super_admin.')
    ->group(function () {
        Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('user.roles.edit');
        Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('user.roles.update');
    });

Route::middleware($superAdminAdmin)
    ->prefix('activate-account')
    ->name('activate_account')
    ->group(function () {
        Route::get('pending-users/{user}/edit', [PendingUserController::class, 'edit'])->name('pending_users.edit');
        Route::put('pending-users/{user}', [PendingUserController::class, 'update'])->name('pending_users.update');
        Route::get('pending-users', [PendingUserController::class, 'index'])->name('pending_users.index');
        Route::get('pending-users/{user}', [PendingUserController::class, 'show'])->name('pending_users.show');
    });

/*
|-----------------------------------------------------------------------
| Contract creation helpers
|-----------------------------------------------------------------------
*/
Route::middleware($adminStaffOnly)->group(function () {
    Route::get('/buildings/{residence}', [ContractController::class, 'getBuildings']);
    Route::get('/floors/{building}', [ContractController::class, 'getFloors']);
    Route::get('/rooms/{floor}', [ContractController::class, 'getRooms']);
    Route::patch('/contracts/{contract}/archived', [ContractController::class, 'archived'])->name('contracts.archive');
});

/*
|-----------------------------------------------------------------------
| Dashboards
|-----------------------------------------------------------------------
*/
Route::get('/super_admin/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware($superAdminOnly)->name('super_admin.dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware($every)
    ->name('dashboard');

Route::get('/search', SearchController::class)
    ->middleware($every)
    ->name('search');

/*
|-----------------------------------------------------------------------
| Shared profile routes
|-----------------------------------------------------------------------
*/
Route::middleware($profileAccess)->group(function () {
    Route::get('/profile/view', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
});

/*
|-----------------------------------------------------------------------
| Super admin CRUD
|-----------------------------------------------------------------------
*/
Route::middleware($adminOnly)->resource('residences', ResidenceController::class)->scoped();
Route::middleware($adminStaffOnly)->get('residences/{residence}/rooms', [ResidenceController::class, 'rooms'])->name('residences.rooms');
Route::middleware($adminOnly)->resource('residences.buildings', ResidenceBuildingController::class)->scoped();
Route::middleware($adminOnly)->resource('buildings.floors', BuildingFloorController::class)->scoped();
Route::middleware($adminOnly)->resource('floors.rooms', FloorRoomController::class)->scoped();
Route::middleware($adminStaffOnly)->resource('contracts', ContractController::class)->scoped();

Route::middleware($superAdminAdmin)->resource('users', UserController::class)->only(['index', 'show', 'update', 'destroy'])->scoped();
Route::middleware($superAdminAdmin)->put('users/{user}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
Route::middleware($adminOnly)->resource('roles', RoleController::class)->only(['index', 'show'])->scoped();
/*
|-----------------------------------------------------------------------
| Event payment types
|-----------------------------------------------------------------------
*/
Route::middleware($eventPaymentTypeAccess)->resource('event_payment_types', EventPaymentTypeController::class)->scoped();

/*
|-----------------------------------------------------------------------
| Payment history
|-----------------------------------------------------------------------
*/
Route::middleware($adminStaffOnly)->group(function () {
    Route::resource('payment_histories', PaymentHistoryController::class)->scoped();
    Route::post('payment_histories/export', [PaymentHistoryController::class, 'export'])->name('payment_histories.export');
});

/*
|-----------------------------------------------------------------------
| Payments
|-----------------------------------------------------------------------
*/
Route::middleware($adminStaffOnly)->group(function () {
    Route::resource('payments', PaymentController::class)->only('index');
    Route::post('/payments/{payment}/validate', [PaymentController::class, 'validatePayment'])->name('payments.validate');
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
});
Route::middleware($paymentAccess)->group(function () {
    Route::get('/payments/{payment}', [PaymentController::class, 'payForm'])->name('payments.pay.form');
    Route::get('/payments/{payment}/pay', [PaymentController::class, 'showPay'])->name('payments.show.pay');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
});

require __DIR__.'/auth.php';
