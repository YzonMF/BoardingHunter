<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccommodationController;

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

        Route::get('/inquiries', function () {
            return view('inquiries/showinquiries');
        })->name('inquiries.show');
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