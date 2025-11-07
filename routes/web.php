<?php
use App\Http\Controllers\UserController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccommodationController;
use GuzzleHttp\Promise\Create;

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
Route::get('/inquiries', function () {
    return view('inquiries/showinquiries');
})->name('inquiries.show');

// Profile
Route::get('/boardinghunter/home/profile', function () {
    return view('profiles/showprofile');
})->name('profile.show');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('profile.show');


// User Routes - admin
// get-users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// posts-users
Route::post('/users', [UserController::class, 'store']);

// put-users
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// delete-users
Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');

Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');
