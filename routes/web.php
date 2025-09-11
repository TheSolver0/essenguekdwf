<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonController;
// use App\Http\Controller\Auth\LoginController;
use NotchPay\NotchPay;
use NotchPay\Payment;


//verification don
Route::get('/don/event', [DonController::class, 'index'])->name('don.event');

//event par l'admin dans home
Route::resource('events', EventController::class);
//contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Authentification admin
//Login partagé
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard user (protégé)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard'); // resources/views/dashboard.blade.php
    })->name('dashboard');
});

// Dashboard admin (protégé)
Route::middleware(['auth', 'is_admin'])->group(function () {
   Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

//test

//Route::get('/test-admin', function () {
   // return 'Middleware chargé !';
//})->middleware('is_admin');





Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
// Page d'accueil
//Route::get('/', function () {
    //return view('home'); // resources/views/home.blade.php
//})->name('home');

Route::get('/', [PageController::class, 'home'])->name('home');

// Pages supplémentaires (navigation)
Route::get('/about', function () {
    return view('about'); // resources/views/about.blade.php
})->name('about');

Route::get('/activity', function () {
    return view('activity'); // resources/views/activity.blade.php
})->name('activity');

// Route pour afficher l’activité (posts)
Route::get('/activity', [PostController::class, 'index'])->name('activity');
// Route::get('/activity', [PageController::class, 'activity'])->name('activity');

//Route::get('/activity/{post}', [PageController::class, 'showPost'])->name('activity.show');



Route::get('/media', function () {
    // return view('media'); // resources/views/media.blade.php
})->name('media');
Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

Route::get('/implantation', function () {
    return view('implantation'); // resources/views/implantation.blade.php
})->name('implantation');

Route::get('/contact', function () {
    return view('contact'); // resources/views/contact.blade.php
})->name('contact');


// Gestion des posts
Route::resource('posts', PostController::class)
    ->only(['index', 'show', 'create', 'store']);

Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store');

// Likes
Route::post('/posts/{post}/like', [LikeController::class, 'store'])
    ->middleware('auth')
    ->name('posts.like');

Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])
    ->middleware('auth')
    ->name('posts.unlike');

// Commentaires
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comment');

// Déconnexion
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('home')->with('success', 'Déconnexion réussie !');
})->name('logout');

// Dashboard protégé par auth
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route de Donation
Route::get('/give', [PageController::class, 'give'])->name('give');
// Route::post('/give', [PageController::class, 'processGive'])->name('give.process');
