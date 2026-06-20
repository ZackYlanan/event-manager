<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // If the user is an admin, send them to the new analytics dashboard
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // If the user is a student, skip the dashboard and send them straight to the events list
    if (auth()->user()->role === 'student') {
        return redirect()->route('events.directory');
    }

    return view('dashboard'); // just in case
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

        Route::get('/admin/checkin', [RegistrationController::class, 'showCheckInForm'])->name('admin.checkin'); // check in page

        Route::post('/admin/checkin', [RegistrationController::class, 'processCheckIn'])->name('admin.checkin.process'); // process check in

        Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/admin/events/{id}', [EventController::class, 'update'])->name('events.update');

        Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('events.destroy'); // delete event

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); // route for admin dashboard
    });


    // --- STUDENT ROUTES: Registering for Events ---
    Route::middleware('role:student')->group(function () {
        Route::get('/events', [EventController::class, 'publicDirectory'])->name('events.directory');
        Route::get('/my-tickets', [RegistrationController::class, 'myTickets'])->name('tickets.index');
        Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
    });
});

require __DIR__ . '/auth.php';

// --- FRONTEND SANDBOX ---
// Allows frontend developers to test views without affecting the main app routes.
// To use, create a blade file in resources/views/sandbox/ and navigate to /sandbox/filename
Route::get('/sandbox/{view?}', function ($view = 'index') {
    $viewPath = 'sandbox.' . str_replace('/', '.', $view);

    if (view()->exists($viewPath)) {
        return view($viewPath);
    }

    abort(404, "Sandbox view [resources/views/sandbox/{$view}.blade.php] not found.");
})->where('view', '.*');
