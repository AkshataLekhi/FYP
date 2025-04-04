<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;

// Landing page
Route::get('/', function () {
    return view('landingPage');
})->name('home');

// Main feed page (should ideally load posts from PostController@index)
Route::get('/mainPage', [PostController::class, 'index'])->name('mainPage');

// Profile route
Route::get('/profile', [MainController::class, 'profile'])->name('profile');

// Auth routes
Route::get('/signup', [MainController::class, 'signup']);
Route::get('/login', [MainController::class, 'login']);

Route::post('/loginUser', [MainController::class, 'loginUser']);
Route::post('/signupUser', [MainController::class, 'signupUser'])->name('signupUser');
Route::post('/updateUser', [MainController::class, 'updateUser'])->name('updateUser');

// Logout (using closure is okay here)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully!');
})->name('logout');

// Post creation
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// Create page (form to upload posts — if different than posts.create)
Route::get('/create', function () {
    return view('create');
})->name('create');

// Rating submission
Route::post('/rating', [RatingController::class, 'add']);
