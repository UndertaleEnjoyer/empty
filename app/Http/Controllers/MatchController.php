<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Team;
use App\Models\Goal;
use App\Models\Player;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = MatchModel::with('team1', 'team2', 'goals')->paginate(10);
        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'required|date_format:Y-m-d\TH:i',
            'venue' => 'required|string',
        ]);

        MatchModel::create($request->all());
        return redirect()->route('matches.index')->with('success', 'Матч успешно создан');
    }

    public function show($id)
    {
        $match = MatchModel::with('team1', 'team2', 'goals.player')->findOrFail($id);
        $teamStats = [
            'team1' => $match->goals->filter(fn($g) => $g->player->team_id == $match->team1_id)->count(),
            'team2' => $match->goals->filter(fn($g) => $g->player->team_id == $match->team2_id)->count(),
        ];
        return view('matches.show', compact('match', 'teamStats'));
    }

    public function edit($id)
    {
        $match = MatchModel::findOrFail($id);
        $teams = Team::all();
        return view('matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, $id)
    {
        $match = MatchModel::findOrFail($id);

        $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'required|date_format:Y-m-d\TH:i',
            'venue' => 'required|string',
        ]);

        $match->update($request->all());
        return redirect()->route('matches.show', $match->id)->with('success', 'Матч успешно обновлен');
    }

    public function destroy($id)
    {
        $match = MatchModel::findOrFail($id);
        $match->goals()->delete();
        $match->delete();
        return redirect()->route('matches.index')->with('success', 'Матч успешно удален');
    }

    public function addGoal(Request $request, $id)
    {
        $match = MatchModel::findOrFail($id);

        $request->validate([
            'player_id' => 'required|exists:players,id',
            'minute' => 'required|integer|min:0|max:120',
        ]);

        $player = Player::findOrFail($request->player_id);
        if ($player->team_id !== $match->team1_id && $player->team_id !== $match->team2_id) {
            return back()->with('error', 'Игрок не принадлежит ни одной из команд');
        }

        Goal::create([
            'match_id' => $id,
            'player_id' => $request->player_id,
            'minute' => $request->minute,
        ]);

        return back()->with('success', 'Гол добавлен');
    }

    public function deleteGoal($id)
    {
        $goal = Goal::findOrFail($id);
        $matchId = $goal->match_id;
        $goal->delete();
        return redirect()->route('matches.show', $matchId)->with('success', 'Гол удален');
    }

}
