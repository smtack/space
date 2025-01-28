<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->middleware('guest');

Route::get('/home', HomeController::class)->middleware(['auth'])->name('home');

Route::get('/search', SearchController::class)->middleware('auth')->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user:username}', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/bio', [ProfileController::class, 'bio'])->name('profile.bio');
    Route::post('/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::post('users/follow/{user}', [UserController::class, 'follow'])->name('users.follow');
    Route::post('users/unfollow/{user}', [UserController::class, 'unfollow'])->name('users.unfollow');
});

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('users/like/{post}', [LikeController::class, 'like'])->name('posts.like');
    Route::post('users/unlike/{post}', [LikeController::class, 'unlike'])->name('posts.unlike');

    Route::resource('replies', ReplyController::class)
        ->only(['store', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
