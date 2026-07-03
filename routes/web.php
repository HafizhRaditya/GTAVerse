<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik GTAVerse
|--------------------------------------------------------------------------
| Panel admin (Filament) tersedia otomatis di /admin
| melalui App\Providers\Filament\AdminPanelProvider.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/karakter', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/karakter/{character:slug}', [CharacterController::class, 'show'])->name('characters.show');
