<h1>Edit Player</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('players.update', $player->id) }}">
    @csrf
    @method('PUT')

    <select name="team_id">
        @foreach($teams as $team)
            <option value="{{ $team->id }}"
                {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
                {{ $team->name }}
            </option>
        @endforeach
    </select>

    <input type="text" name="full_name" value="{{ old('full_name', $player->full_name) }}">
    <input type="text" name="position" value="{{ old('position', $player->position) }}">

    <button type="submit">Update</button>
</form>
