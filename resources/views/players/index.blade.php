<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ Список игроков</h2>
    </x-slot>

    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h4 fw-bold">Футбольные игроки</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('players.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-lg"></i> Добавить игрока
            </a>
        </div>
    </div>

    <!-- Pagination Settings -->
    <div class="row mb-4">
        <div class="col-md-3">
            <form method="GET" action="{{ route('players.index') }}" class="d-flex gap-2">
                <label for="perPage" class="col-form-label fw-semibold">Элементов на странице:</label>
                <select name="per_page" id="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Players Table -->
    <div class="card shadow-lg border-0 players-table-card">
        <div class="card-header bg-gradient-football text-white py-3">
            <h5 class="m-0">
                <i class="bi bi-people"></i> Все игроки
            </h5>
        </div>
        <div class="card-body p-0 players-table-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 players-table">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-person"></i> ФИО</th>
                            <th><i class="bi bi-shield"></i> Команда</th>
                            <th><i class="bi bi-dribbble"></i> Позиция</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($players as $player)
                            <tr>
                                <td class="fw-semibold player-name">{{ $player->full_name }}</td>
                                <td>
                                    @if($player->team)
                                        <span class="badge bg-info">{{ $player->team->name }}</span>
                                    @else
                                        <span class="player-no-team">Не назначена</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $player->position }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('players.show', $player->id) }}" class="btn btn-sm btn-info" title="Просмотр">
                                        <i class="bi bi-eye"></i> Просмотр
                                    </a>
                                    <a href="{{ route('players.edit', $player->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                        <i class="bi bi-pencil"></i> Изменить
                                    </a>
                                    <form action="{{ route('players.destroy', $player->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Вы уверены, что хотите удалить игрока?')" title="Удалить">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center empty-state py-5">
                                    <i class="bi bi-inbox"></i> Нет игроков. <a href="{{ route('players.create') }}" class="fw-bold">Добавить первого игрока</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $players->links() }}
    </div>

    <style>
    .bg-gradient-football {
        background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
    }

    /* Заголовок страницы */
    h1.h4 {
        color: #ffffff !important;
    }

    /* Лейбл "Элементов на странице" */
    .col-form-label {
        color: #ffffff !important;
    }

    /* Карточка таблицы */
    .players-table-card {
        background-color: #ffffff !important;
    }

    .players-table-body {
        background-color: #ffffff !important;
        color: #333 !important;
    }

    .players-table {
        color: #333 !important;
    }

    .players-table thead th {
        color: #333 !important;
        background-color: #f8f9fa !important;
    }

    .players-table tbody td {
        color: #333 !important;
        background-color: #ffffff !important;
        vertical-align: middle;
    }

    .player-name {
        color: #1a472a !important;
    }

    .player-no-team {
        color: #666 !important;
    }

    .empty-state {
        color: #666 !important;
    }

    .empty-state a {
        color: #1a472a !important;
    }


    .form-select {
        color: #333 !important;
        background-color: #ffffff !important;
    }
</style>
</x-app-layout>
