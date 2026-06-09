<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Players</title>
</head>
<body>

<h1>Players</h1>

<a href="{{ route('players.create') }}">+ Добавить игрока</a>

<form method="GET" action="{{ route('players.index') }}" style="margin:15px 0;">
    <label>Элементов на странице:</label>
    <select name="per_page" onchange="this.form.submit()">
        <option value="5"  {{ request('per_page',5)==5?'selected':'' }}>5</option>
        <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
        <option value="15" {{ request('per_page')==15?'selected':'' }}>15</option>
        <option value="20" {{ request('per_page')==20?'selected':'' }}>20</option>
    </select>
</form>

<hr>

@foreach($players as $player)
    <p>
        {{ $player->full_name }}

        <a href="{{ route('players.show',$player->id) }}">Просмотр</a>
        <a href="{{ route('players.edit',$player->id) }}">Изменить</a>

        <form action="{{ route('players.destroy',$player->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button>Delete</button>
        </form>
    </p>
@endforeach

<div style="margin-top:20px">
    {{ $players->links() }}
</div>

</body>
</html>
