<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik GTAVerse
|--------------------------------------------------------------------------
| Panel admin tersedia di /admin (login: /admin/login).
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/karakter', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/karakter/{character:slug}', [CharacterController::class, 'show'])->name('characters.show');

Route::get('/kotak-saran', [MessageController::class, 'create'])->name('messages.create');
Route::post('/kotak-saran', [MessageController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('messages.store');

/*
|--------------------------------------------------------------------------
| Panel Admin GTAVerse
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('games', Admin\GameController::class)->except(['show']);
        Route::resource('articles', Admin\ArticleController::class)->except(['show']);
        Route::resource('characters', Admin\CharacterController::class)->except(['show']);
        Route::resource('categories', Admin\CategoryController::class)->except(['show']);

        Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/toggle', [Admin\MessageController::class, 'toggle'])->name('messages.toggle');
        Route::delete('messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
