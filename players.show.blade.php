<h1>{{ $player->full_name }}</h1>
<p>Team: {{ $player->team->name }}</p>

<h3>Matches</h3>
<ul>
@foreach($player->goals as $goal)
    <li>
        Match #{{ $goal->match->id }} — {{ $goal->minute }} minute
    </li>
@endforeach
</ul>
