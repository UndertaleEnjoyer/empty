<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

// API-контроллер для таблицы players — возвращает JSON, а не Blade-шаблоны
class PlayerControllerApi extends Controller
{
    /**
     * Постраничное получение игроков.
     * GET-параметры:
     *   page    — номер страницы (начиная с нуля)
     *   perpage — количество элементов на странице
     */
    public function index(Request $request)
    {
        return response(Player::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->get());
    }

    /**
     * Общее количество записей в таблице players (для пагинации).
     */
    public function total()
    {
        return response(Player::all()->count());
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
