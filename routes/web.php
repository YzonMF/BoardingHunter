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
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// posts-users
Route::post('/users', [UserController::class, 'store']);

// put-users
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// delete-users
Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');



use App\Http\Controllers\AccommodationController;

Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');

Route::get('/Accommodation', [AccommodationController::class, 'index'])->name('Accommodation.index');
Route::get('/Accommodation/create', [AccommodationController::class, 'create'])->name('Accommodation.create');
Route::get('/Accommodation/{Accommodation}', [AccommodationController::class, 'show'])->name('Accommodation.show');
Route::get('/Accommodation/{Accommodation}/edit', [AccommodationController::class, 'edit'])->name('Accommodation.edit');

// posts-users
Route::post('/Accommodation', [UserController::class, 'store']);

// put-users
Route::put('/Accommodation/{Accommodation}', [UserController::class, 'update'])->name('Accommodation.update');

// delete-users
Route::delete('/Accommodation/{Accommodation}',[UserController::class,'destroy'])->name('Accommodation.destroy');

