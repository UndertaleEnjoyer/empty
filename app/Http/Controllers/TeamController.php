<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $teams = Team::paginate($perPage);
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
        ], [
            'name.required' => 'Название команды обязательно',
            'name.unique' => 'Команда с таким названием уже существует',
        ]);

        Team::create(['name' => $request->name]);

        return redirect()->route('teams.index')->with('success', 'Команда успешно создана!');
    }

    public function show($id)
    {
        $team = Team::with('players')->findOrFail($id);
        return view('teams.show', compact('team'));
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $id,
        ], [
            'name.required' => 'Название команды обязательно',
            'name.unique' => 'Команда с таким названием уже существует',
        ]);

        $team->update(['name' => $request->name]);

        return redirect()->route('teams.index')->with('success', 'Команда успешно обновлена!');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Команда успешно удалена!');
    }
}
