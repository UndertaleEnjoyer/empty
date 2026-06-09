<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ Список команд</h2>
    </x-slot>

    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h4 fw-bold">Футбольные команды</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('teams.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-lg"></i> Создать команду
            </a>
        </div>
    </div>

    <!-- Pagination Settings -->
    <div class="row mb-4">
        <div class="col-md-3">
            <form method="GET" action="{{ route('teams.index') }}" class="d-flex gap-2">
                <label for="perPage" class="col-form-label">Элементов на странице:</label>
                <select name="per_page" id="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page', 10) == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
        </div>
    </div>

    @if($teams->count() > 0)
        <div class="row">
            @foreach($teams as $team)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-lg h-100 border-0 team-card">
                        <div class="card-header bg-gradient-football text-white py-3">
                            <h5 class="card-title m-0">
                                <i class="bi bi-shield-check"></i> {{ $team->name }}
                            </h5>
                        </div>
                        <div class="card-body team-body">
                            <div class="team-stats">
                                <p class="team-stat-text mb-2">
                                    <i class="bi bi-people"></i> Игроки: <strong>{{ $team->players->count() }}</strong>
                                </p>
                                <p class="team-stat-text">
                                    <i class="bi bi-calendar-event"></i> ID: <strong>#{{ $team->id }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-info flex-grow-1" title="Просмотр">
                                    <i class="bi bi-eye"></i> Просмотр
                                </a>
                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                    <i class="bi bi-pencil"></i> Изменить
                                </a>
                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Вы уверены, что хотите удалить команду?')" title="Удалить">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $teams->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-5" role="alert">
            <h5 class="alert-heading">⚽ Команды не найдены</h5>
            <p class="m-0">
                <a href="{{ route('teams.create') }}" class="alert-link">Создайте первую команду</a>
            </p>
        </div>
    @endif

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .team-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
        }

        .team-body {
            background-color: #fff;
            color: #333;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(26, 71, 42, 0.2) !important;
        }

        .team-stats {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
        }

        .team-stat-text {
            color: #666 !important;
            margin-bottom: 0.5rem;
        }

        .team-stat-text strong {
            color: #333 !important;
        }
    </style>
</x-app-layout>
