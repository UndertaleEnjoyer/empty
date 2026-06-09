<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;

// API-контроллер для таблицы matches — возвращает JSON, а не Blade-шаблоны
class MatchControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Возвращаем все матчи в виде JSON
        return response(MatchModel::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Возвращаем один матч по id; если нет — вернёт null (не 404)
        return response(MatchModel::find($id));
    }
}
