<?php

use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\FloorRoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceBuildingController;
use App\Http\Controllers\ResidenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
});
Route::middleware(['auth', 'permission:create_residence'])->get('/residences/create', function () {
    return view('residence.create');
});
Route::middleware(['auth', 'role:admin'])->resource('residences', ResidenceController::class)->scoped();
Route::middleware(['auth', 'role:admin'])->resource('residences.buildings', ResidenceBuildingController::class)->scoped();
Route::middleware(['auth', 'role:admin'])->resource('buildings.floors', BuildingFloorController::class)->scoped();
Route::middleware(['auth', 'role:admin'])->resource('floors.rooms', FloorRoomController::class)->scoped();
require __DIR__.'/auth.php';
