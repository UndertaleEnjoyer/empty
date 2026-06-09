<?php

namespace App\Http\Controllers;

use App\Models\Team;

// API-контроллер для таблицы teams — возвращает JSON, а не Blade-шаблоны
class TeamControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Возвращаем все команды в виде JSON
        return response(Team::all());
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
