<?php

use App\Http\Controllers\UserController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These

|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/*register/login*/
Route::get('/register', function () {
    return view('auth/register');
});
Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/forgotpassword', function () {
    return view('auth/forgot');
});

/*ui*/

// Inquiries
Route::get('/boardinghunter/home/showinquiries', function () {
    return view('inquiries/showinquiries');
})->name('inquiries.show');

// Profile
Route::get('/boardinghunter/home/profile', function () {
    return view('profiles/showprofile');
})->name('profile.show');


// Admin routes (using admin layout)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        // Simple dashboard with user statistics
        $totalUsers = \App\Models\User::count();
        $roomOwners = \App\Models\User::where('Role', 'roomOwner')->count();
        $roomSeekers = \App\Models\User::where('Role', 'roomSeeker')->count();

        return view('admin.dashboard', compact('totalUsers', 'roomOwners', 'roomSeekers'));
    })->name('admin.dashboard');

    Route::resource('users', UserController::class);
});

// Reviews routes
Route::resource('reviews', \App\Http\Controllers\CreateReviewController::class);

