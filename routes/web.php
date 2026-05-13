<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMatchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('matches.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Matches & Seats
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show');
    Route::post('/seats/lock', [SeatController::class, 'lock'])->name('seats.lock');

    // Purchases
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/tickets/{ticket}', [PurchaseController::class, 'show'])->name('tickets.show');

    // Ranking
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
});

// Admin Area
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('matches', AdminMatchController::class);
});

require __DIR__.'/auth.php';
