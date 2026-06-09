<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/* -------- PLAYERS -------- */

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players/{id}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
    Route::get('/players/{id}', [PlayerController::class, 'show'])->name('players.show');
    Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');

});

/* -------- TEAMS -------- */

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
});

/* -------- MATCHES -------- */

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/create', [MatchController::class, 'create'])->name('matches.create');
    Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{id}', [MatchController::class, 'show'])->name('matches.show');
    Route::get('/matches/{id}/edit', [MatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{id}', [MatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{id}', [MatchController::class, 'destroy'])->name('matches.destroy');
    Route::post('/matches/{id}/add-goal', [MatchController::class, 'addGoal'])->name('matches.addGoal');
    Route::delete('/goals/{id}', [MatchController::class, 'deleteGoal'])->name('goals.destroy');
});


/* -------- PROFILE -------- */

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
});

/* -------- OTHER -------- */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:sanctum', 'verified'])->name('dashboard');

Route::get('/hello', function () {
    return view('hello', ['title' => 'hello world!']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');
