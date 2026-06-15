<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ADMIN ROUTES: Managing Events ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/admin/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/admin/events', [EventController::class, 'store'])->name('events.store');
    });


    // --- STUDENT ROUTES: Registering for Events ---
    Route::middleware('role:student')->group(function () {
        Route::get('/events', [EventController::class, 'publicDirectory'])->name('events.directory');
        Route::get('/my-tickets', [RegistrationController::class, 'myTickets'])->name('tickets.index');
        Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
    });
});

require __DIR__ . '/auth.php';
