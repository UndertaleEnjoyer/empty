<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        
        $perPage = $request->get('per_page', 5);

        $players = Player::orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString(); 

        return view('players.index', compact('players', 'perPage'));
    }

    public function show($id)
    {
        $player = Player::with('team')->findOrFail($id);
        return view('players.show', compact('player'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id'   => 'required|exists:teams,id',
            'full_name' => 'required|string|max:255',
            'position'  => 'required|string|max:100',
        ]);

        Player::create($validated);

        return redirect()->route('players.index')->with('success', 'Игрок успешно добавлен!');
    }

    public function edit($id)
    {
        $player = Player::findOrFail($id);
        $teams = Team::all();

        return view('players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'team_id'   => 'required|exists:teams,id',
            'full_name' => 'required|string|max:255',
            'position'  => 'required|string|max:100',
        ]);

        Player::findOrFail($id)->update($validated);

        return redirect()->route('players.index')->with('success', 'Игрок успешно обновлен!');
    }

    public function destroy($id)
    {
        Player::findOrFail($id)->delete();
        return redirect()->route('players.index')->with('success', 'Игрок успешно удален!');
    }
}
