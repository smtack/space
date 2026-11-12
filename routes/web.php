<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::middleware('auth')->group(function () {
    // Pages
    Route::get('/home', HomeController::class)->name('home');
    Route::get('/explore', ExploreController::class)->name('explore');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/likes', [LikeController::class, 'index'])->name('posts.likes');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('posts.bookmarks');
    Route::get('/profile/{user:username}', ProfileController::class)->name('profile.index');
    Route::get('/search', SearchController::class)->name('search');

    // Posts and Replies
    Route::resource('posts', PostController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::resource('replies', ReplyController::class)->only(['store', 'update', 'destroy']);

    // Likes, Bookmarks, Reposts and Follows
    Route::post('/users/like/{post}', [LikeController::class, 'like'])->name('posts.like');
    Route::post('/users/unlike/{post}', [LikeController::class, 'unlike'])->name('posts.unlike');

    Route::post('/users/bookmark/{post}', [BookmarkController::class, 'bookmark'])->name('posts.bookmark');
    Route::post('/users/removeBookmark/{post}', [BookmarkController::class, 'removeBookmark'])->name('posts.removeBookmark');

    Route::post('/users/repost/{post}', [RepostController::class, 'repost'])->name('posts.repost');
    Route::post('/users/removeRepost/{post}', [RepostController::class, 'removeRepost'])->name('posts.removeRepost');

    Route::post('/users/follow/{user}', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/users/unfollow/{user}', [UserController::class, 'unfollow'])->name('users.unfollow');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('profile.edit');
    Route::patch('/profile', [SettingsController::class, 'update'])->name('profile.update');
    Route::patch('/bio', [SettingsController::class, 'bio'])->name('profile.bio');
    Route::post('/avatar', [SettingsController::class, 'avatar'])->name('profile.avatar');
    Route::patch('/appearance', [SettingsController::class, 'appearance'])->name('profile.appearance');
    Route::delete('/profile', [SettingsController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
