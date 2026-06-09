<?php

use App\Http\Controllers\TeamControllerApi;
use App\Http\Controllers\PlayerControllerApi;
use App\Http\Controllers\MatchControllerApi;
use Illuminate\Support\Facades\Route;

// Маршруты для таблицы teams
Route::get('/team', [TeamControllerApi::class, 'index']);
Route::get('/team/{id}', [TeamControllerApi::class, 'show']);

// Маршруты для таблицы players
Route::get('/player', [PlayerControllerApi::class, 'index']);
Route::get('/player/{id}', [PlayerControllerApi::class, 'show']);

// Маршруты для таблицы matches
Route::get('/match', [MatchControllerApi::class, 'index']);
Route::get('/match/{id}', [MatchControllerApi::class, 'show']);
