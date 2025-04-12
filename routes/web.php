<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;

// Landing page
Route::get('/', function () {
    return view('landingPage');
})->name('home');

// Main feed
Route::get('/mainPage', [PostController::class, 'index'])->name('mainPage');

// Public profile/login/signup routes
Route::get('/profile', [MainController::class, 'profile'])->name('profile');
Route::get('/signup', [MainController::class, 'signup']);
Route::get('/login', [MainController::class, 'login'])->name('login');
Route::post('/loginUser', [MainController::class, 'loginUser']);
Route::post('/signupUser', [MainController::class, 'signupUser'])->name('signupUser');
Route::post('/updateUser', [MainController::class, 'updateUser'])->name('updateUser');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully!');
})->name('logout');

// Guest-only route to show create page
Route::get('/create', function () {
    return view('create');
})->name('create');

// ✅ PROTECTED ROUTES — only for logged-in users
Route::middleware(['auth'])->group(function () {
    // Post create/store
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Post edit/delete/save
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');
    Route::post('/posts/{post}/unsave', [PostController::class, 'unsave'])->name('posts.unsave');

    // Ratings, Polls, Comments, Likes
    Route::post('/rating', [RatingController::class, 'add']);
    Route::post('/poll/vote', [PollController::class, 'vote'])->name('poll.vote');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/like', [LikeController::class, 'toggle'])->name('like.toggle');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/{id}/mark', [NotificationController::class, 'markOneAsRead'])->name('notifications.markOne');

    // Account page
    Route::get('/account', [AccountController::class, 'index'])->name('account');
});
