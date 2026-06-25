<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Show the welcome splash screen
Route::get('/', function () {
    return view('welcome');
});

// Redirect users to their respective dashboards based on their role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'student') {
        return redirect()->route('student.home');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Show the user profile editing form
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Update the user's profile information
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Delete the user's account
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ADMIN ROUTES: Managing Events ---
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Show the list of all events created by the admin
        Route::get('/events', [EventController::class, 'index'])->name('events.index');

        // Show the form to create a new event
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

        // Store the newly created event in the database
        Route::post('/events', [EventController::class, 'store'])->name('events.store');

        // Show the check-in form/scanner for event attendees
        Route::get('/checkin', [RegistrationController::class, 'showCheckInForm'])->name('admin.checkin');

        // Process a submitted ticket code for check-in
        Route::post('/checkin', [RegistrationController::class, 'processCheckIn'])->name('admin.checkin.process');

        // Manually check in an attendee without a ticket code
        Route::post('/checkin/{id}/manual', [RegistrationController::class, 'manualCheckIn'])->name('admin.checkin.manual');

        // Show the form to edit an existing event
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');

        // Update the existing event in the database
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

        // Delete an event from the database
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

        // Show the admin analytics dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Show the detailed report for a specific event
        Route::get('/events/{id}/report', [EventReportController::class, 'showReport'])->name('events.report.show');

        // Get the chart/graph data for a specific event's report
        Route::get('/events/{id}/report/data', [EventReportController::class, 'getReportData'])->name('events.report.data');

        // Export the event attendees data as a CSV file
        Route::get('/events/{id}/report/export', [EventReportController::class, 'exportCsv'])->name('events.report.export');
    });


    // --- STUDENT ROUTES: Registering for Events ---
    Route::middleware('role:student')->prefix('student')->group(function () {
        // Show the student's personalized home page
        Route::get('/home', [EventController::class, 'studentHome'])->name('student.home');

        // Show the public directory of all upcoming events
        Route::get('/events', [EventController::class, 'publicDirectory'])->name('events.directory');

        // Show the student's registered tickets
        Route::get('/my-tickets', [RegistrationController::class, 'myTickets'])->name('tickets.index');

        // Register a student for a specific event
        Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');

        // Show the detailed information page for a specific event
        Route::get('/events/{id}/show', [EventController::class, 'show'])->name('events.show');

        // Cancel a student's pending ticket
        Route::delete('/tickets/{id}/cancel', [RegistrationController::class, 'cancelTicket'])->name('tickets.cancel');
    });
});

Route::fallback(function () {
    abort(404);
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
