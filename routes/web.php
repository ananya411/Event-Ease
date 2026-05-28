<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\GuestRsvpController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rsvp/{token}', [GuestRsvpController::class, 'show'])->name('rsvp.show');
Route::post('/rsvp/{token}', [GuestRsvpController::class, 'respond'])->name('rsvp.respond');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| NOTIFICATION ROUTE (IMPORTANT)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/notifications/read/{id}', function ($id) {

        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();

    })->name('notifications.read');

});

/*
|--------------------------------------------------------------------------
| PLANNER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:planner'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('events', EventController::class);

    /*
    |--------------------------------------------------------------------------
    | Guests
    |--------------------------------------------------------------------------
    */

    Route::get('/events/{eventId}/guests', [GuestController::class, 'index'])
        ->name('guests.index');

    Route::get('/events/{eventId}/guests/create', [GuestController::class, 'create'])
        ->name('guests.create');

    Route::post('/events/{eventId}/guests/store', [GuestController::class, 'store'])
        ->name('guests.store');

    Route::post('/guests/{guestId}/status', [GuestController::class, 'updateStatus'])
        ->name('guests.status');

    Route::delete('/guests/{guestId}', [GuestController::class, 'destroy'])
        ->name('guests.destroy');

    /*
    |--------------------------------------------------------------------------
    | Budgets
    |--------------------------------------------------------------------------
    */

    Route::get('/events/{eventId}/budgets', [BudgetController::class, 'index'])
        ->name('budgets.index');

    Route::get('/events/{eventId}/budgets/create', [BudgetController::class, 'create'])
        ->name('budgets.create');

    Route::post('/events/{eventId}/budgets/store', [BudgetController::class, 'store'])
        ->name('budgets.store');

    Route::delete('/budgets/{id}', [BudgetController::class, 'destroy'])
        ->name('budgets.destroy');

    /*
    |--------------------------------------------------------------------------
    | Bookings
    |--------------------------------------------------------------------------
    */

    Route::get('/planner/bookings', [BookingController::class, 'plannerBookings'])
        ->name('planner.bookings');

    Route::get('/events/{eventId}/vendors/{vendorId}/book', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/events/{eventId}/vendors/{vendorId}/book', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::delete('/bookings/{bookingId}', [BookingController::class, 'destroy'])
        ->name('bookings.destroy');
});

use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

});

/*
|--------------------------------------------------------------------------
| VENDOR ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:vendor'])->group(function () {

    Route::get('/vendor/bookings', [BookingController::class, 'vendorBookings'])
        ->name('vendor.bookings');

    Route::post('/vendor/bookings/{bookingId}/status', [BookingController::class, 'updateStatus'])
        ->name('bookings.status');
});

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| VENDORS PUBLIC LISTING
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:planner'])->group(function () {
    Route::get('/vendors', [VendorController::class, 'index'])
        ->name('vendors.index');
});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});