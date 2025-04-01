<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('landingPage');
})->name('home');


Route::get('/mainPage', function () {
    return view('mainPage');
})->name('mainPage');

Route::get('/profile', [MainController::class, 'profile'])->name('profile');

Route::get('/signup', [MainController::class, 'signup']);
Route::get('/login', [MainController::class, 'login']);
// Route::post('/logout', [MainController::class, 'logout'])->name('logout');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully!');
})->name('logout');

Route::post('/loginUser', [MainController::class, 'loginUser']);
Route::post('/signupUser', [MainController::class, 'signupUser'])->name('signupUser');
Route::post('/updateUser', [MainController::class, 'updateUser'])->name('updateUser');

Route::get('/create', function () {
    return view('create');
})->name('create');

Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store'); // Fixed store conflict
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
