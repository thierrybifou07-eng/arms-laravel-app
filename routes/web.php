<?php

use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FloorRoomController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceBuildingController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/*
Past route for the creation of contrac
*/
Route::get('/buildings/{residence}', [ContractController::class, 'getBuildings']);
Route::get('/floors/{building}', [ContractController::class, 'getFloors']);
Route::get('/rooms/{floor}', [ContractController::class, 'getRooms']);
Route::get('/super_admin/dashboard', function () {
    return view('super_admin.dashboard');
})->middleware(['auth', 'verified', 'role:super_admin'])->name('super_admin.dashboard');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/avatar', [ProfileController::class, 'updateAvatar'])
        ->name('avatar.update');
});
Route::middleware(['auth', 'role:super_admin'])->resource('residences', ResidenceController::class)->scoped();
Route::middleware(['auth', 'role:super_admin'])->resource('residences.buildings', ResidenceBuildingController::class)->scoped();
Route::middleware(['auth', 'role:super_admin'])->resource('buildings.floors', BuildingFloorController::class)->scoped();

Route::middleware(['auth', 'role:super_admin'])->resource('floors.rooms', FloorRoomController::class)->scoped();
Route::middleware(['auth', 'role:super_admin'])->resource('contracts', ContractController::class)/* ->only(['index','show','update','edit','store','create','archive']) */ ->scoped();

Route::middleware(['auth', 'role:super_admin'])->resource('users', UserController::class)->scoped();
Route::middleware(['auth', 'role:super_admin'])->resource('roles', RoleController::class)->scoped();
Route::middleware(['auth', 'role:super_admin'])->resource('permissions', PermissionController::class)->scoped();
Route::middleware('auth')->group(function () {
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/pay', [PaymentController::class, 'showPay'])->name('payments.show.pay');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
    Route::post('/payments/{payment}/validate', [PaymentController::class, 'validatePayment'])->name('payments.validate');
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
});
require __DIR__.'/auth.php';
