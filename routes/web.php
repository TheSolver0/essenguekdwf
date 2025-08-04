<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    return view('layouts.app');
})->name('home');

Route::resource('posts', PostController::class)->only(['index', 'show', 'create', 'store']);

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comment');
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('home')->with('success', 'Déconnexion réussie !');
})->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
