<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamControllerApi;
use App\Http\Controllers\PlayerControllerApi;
use App\Http\Controllers\MatchControllerApi;
use Illuminate\Support\Facades\Route;

// Публичный маршрут — получение токена
Route::post('/login', [AuthController::class, 'login']);

// Группа защищённых маршрутов (требуют Bearer-токен)
Route::middleware('auth:sanctum')->group(function () {

    // Данные текущего аутентифицированного пользователя
    Route::get('/me', [AuthController::class, 'me']);

    // Деактивация токена (выход)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Маршруты для таблицы teams
    Route::get('/team', [TeamControllerApi::class, 'index']);
    Route::get('/team_total', [TeamControllerApi::class, 'total']);
    Route::post('/team', [TeamControllerApi::class, 'store']);
    Route::get('/team/{id}', [TeamControllerApi::class, 'show']);
    Route::delete('/team/{id}', [TeamControllerApi::class, 'destroy']);
    Route::post('/team/{id}', [TeamControllerApi::class, 'update']);

    // Маршруты для таблицы players
    Route::get('/player', [PlayerControllerApi::class, 'index']);
    Route::get('/player_total', [PlayerControllerApi::class, 'total']);
    Route::get('/player/{id}', [PlayerControllerApi::class, 'show']);

    // Маршруты для таблицы matches
    Route::get('/match', [MatchControllerApi::class, 'index']);
    Route::get('/match/{id}', [MatchControllerApi::class, 'show']);
});
