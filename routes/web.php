<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
<<<<<<< HEAD
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
=======
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
|
*/

Route::get('/', function () {
<<<<<<< HEAD
    return view('welcome');
});
=======
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
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
