<h1>Match {{ $match->id }}</h1>

<p>{{ $match->team1->name }} vs {{ $match->team2->name }}</p>

<h3>Goals</h3>
<ul>
@foreach($match->goals as $goal)
    <li>
        {{ $goal->player->full_name }} — {{ $goal->minute }}'
    </li>
@endforeach
</ul>
