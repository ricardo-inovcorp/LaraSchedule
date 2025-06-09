<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BlockedPeriodController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('availabilities', AvailabilityController::class);
    Route::resource('blocked-periods', BlockedPeriodController::class);
    Route::get('/book', [BookingController::class, 'index'])->name('book.index');
    Route::get('/calendar', [\App\Http\Controllers\AppointmentController::class, 'calendar'])->name('appointments.calendar');
    Route::get('/appointments/{id}', [\App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{id}/approve', [\App\Http\Controllers\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{id}/reject', [\App\Http\Controllers\AppointmentController::class, 'reject'])->name('appointments.reject');
});

// Rotas públicas de agendamento
Route::get('/book/{slug}', [BookingController::class, 'show'])->name('book.show');
Route::post('/book/{slug}', [BookingController::class, 'store'])->name('book.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
