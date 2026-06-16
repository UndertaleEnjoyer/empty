<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

// API-контроллер для таблицы teams — возвращает JSON, а не Blade-шаблоны
class TeamControllerApi extends Controller
{
    /**
     * Постраничное получение команд.
     * GET-параметры:
     *   page    — номер страницы (начиная с нуля)
     *   perpage — количество элементов на странице
     */
    public function index(Request $request)
    {
        return response(Team::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->get());
    }

    /**
     * Общее количество записей в таблице teams (для пагинации).
     */
    public function total()
    {
        return response(Team::all()->count());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Возвращаем одну команду по id; если нет — вернёт null (не 404)
        return response(Team::find($id));
    }
}
