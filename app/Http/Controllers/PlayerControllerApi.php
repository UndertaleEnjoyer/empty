<?php

namespace App\Http\Controllers;

use App\Models\Player;

// API-контроллер для таблицы players — возвращает JSON, а не Blade-шаблоны
class PlayerControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Возвращаем всех игроков в виде JSON
        return response(Player::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Возвращаем одного игрока по id; если нет — вернёт null (не 404)
        return response(Player::find($id));
    }
}
