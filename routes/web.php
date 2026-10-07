<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [AccommodationController::class, 'home'])->name('index');
Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/accommodations/{accommodation}', [AccommodationController::class, 'show'])->name('accommodations.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth/register');
    })->name('register.form');
    
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::get('/login', function () {
        return view('auth/login');
    })->name('login');
    
    Route::post('/login', [UserController::class, 'login'])->name('login.post');

    Route::get('/forgotpassword', function () {
        return view('auth/forgot');
    })->name('password.request');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Boarding Hunter Home (Room Owners & Room Seekers)
    Route::middleware('role:roomOwner,roomSeeker')->group(function () {
        Route::get('/boardinghunter/home', function () {
            return view('boardinghunter.home');
        })->name('boardinghunter.home');

        Route::get('/boardinghunter/home/profile', function () {
            return view('profiles/showprofile');
        })->name('profile.show');

        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.show');
    });

    Route::middleware('role:roomSeeker')->post('/accommodations/{accommodation}/inquiries', [InquiryController::class, 'store'])
        ->name('inquiries.store');

    Route::middleware('role:roomOwner')->post('/inquiries/{inquiry}/reply', [InquiryController::class, 'reply'])
        ->name('inquiries.reply');

    // Reservations (7-day hold, starts when the owner approves) and bookings
    Route::middleware('role:roomOwner,roomSeeker')->group(function () {
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    });

    Route::middleware('role:roomSeeker')->group(function () {
        Route::post('/accommodations/{accommodation}/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::post('/accommodations/{accommodation}/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
        Route::post('/reservations/{reservation}/book', [BookingController::class, 'storeFromReservation'])->name('reservations.book');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });

    // Notifications (any signed-in user)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readall');
    Route::post('/notifications/{id}/open', [NotificationController::class, 'open'])->name('notifications.open');

    // Owner listing management
    Route::middleware('role:roomOwner')->prefix('my-listings')->name('listings.')->group(function () {
        Route::get('/', [ListingController::class, 'index'])->name('index');
        Route::get('/create', [ListingController::class, 'create'])->name('create');
        Route::post('/', [ListingController::class, 'store'])->name('store');
        Route::get('/{accommodation}/edit', [ListingController::class, 'edit'])->name('edit');
        Route::put('/{accommodation}', [ListingController::class, 'update'])->name('update');
        Route::delete('/{accommodation}', [ListingController::class, 'destroy'])->name('destroy');
        Route::delete('/{accommodation}/photos/{photo}', [ListingController::class, 'destroyPhoto'])->name('photos.destroy');
        Route::post('/{accommodation}/amenities', [AmenityController::class, 'store'])->name('amenities.store');
        Route::delete('/{accommodation}/amenities/{amenity}', [AmenityController::class, 'destroy'])->name('amenities.destroy');
    });

    Route::middleware('role:roomOwner')->group(function () {
        Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
        Route::post('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
        Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    });

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // User Management Routes
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});