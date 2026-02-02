<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Routes for Event List and Event Details
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Organiser Routes
Route::middleware(['auth', 'organiser'])->group(function(){
    Route::get('/event/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/event', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->whereNumber('event')->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->whereNumber('event')->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->whereNumber('event')->name('events.destroy');
    Route::get('/organiser/dashboard', [DashboardController::class, 'index'])->name('organiser.dashboard');
});

// Attendee Routes
Route::middleware(['auth', 'attendee'])->group(function(){
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/events/{event}/book', [BookingController::class, 'store'])->name('events.book');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/my-waitlists', [EventController::class, 'index'])->name('waitlists.index');
});

require __DIR__.'/auth.php';
