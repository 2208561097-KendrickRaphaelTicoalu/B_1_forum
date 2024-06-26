<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class);
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/posts/{id}/like', [PostController::class, 'incrementLikes'])->name('posts.incrementLikes');

