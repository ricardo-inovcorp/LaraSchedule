<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BlockedPeriodController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('availabilities', AvailabilityController::class);
    Route::resource('blocked-periods', BlockedPeriodController::class);
    Route::get('/book', [BookingController::class, 'index'])->name('book.index');
});

// Rotas públicas de agendamento
Route::get('/book/{slug}', [BookingController::class, 'show'])->name('book.show');
Route::post('/book/{slug}', [BookingController::class, 'store'])->name('book.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
