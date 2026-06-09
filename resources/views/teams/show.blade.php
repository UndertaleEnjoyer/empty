<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ {{ $team->name }}</h2>
    </x-slot>

    <div class="mb-4 d-flex justify-content-center gap-2">
        <a href="{{ route('teams.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Вернуться к командам
        </a>
        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Редактировать
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 mb-4 team-card">
                <div class="card-header bg-gradient-football text-white py-4">
                    <h5 class="m-0">
                        <i class="bi bi-shield-check"></i> Информация о команде
                    </h5>
                </div>
                <div class="card-body team-info-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="team-label mb-2">Название команды</h6>
                            <h4 class="fw-bold mb-4 team-name">{{ $team->name }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h6 class="team-label mb-2">Всего игроков</h6>
                            <h4 class="fw-bold mb-4 team-count">{{ $team->players->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 players-card">
                <div class="card-header bg-gradient-football text-white py-4">
                    <h5 class="m-0">
                        <i class="bi bi-people"></i> Игроки команды
                    </h5>
                </div>
                <div class="card-body players-body">
                    @if($team->players->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="bi bi-person"></i> Имя</th>
                                        <th><i class="bi bi-dribbble"></i> Позиция</th>
                                        <th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($team->players as $player)
                                        <tr>
                                            <td class="fw-500 player-cell">{{ $player->full_name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $player->position }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('players.show', $player->id) }}" class="btn btn-sm btn-info" title="Просмотр">
                                                    <i class="bi bi-eye"></i> Просмотр
                                                </a>
                                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                                    <i class="bi bi-pencil"></i> Изменить
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> В этой команде пока нет игроков
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .team-card {
            background-color: #fff;
        }

        .team-info-body {
            background-color: #fff;
            color: #333;
        }

        .team-label {
            color: #666 !important;
            font-weight: 600;
        }

        .team-name {
            color: #1a472a !important;
        }

        .team-count {
            color: #27ae60 !important;
        }

        .players-card {
            background-color: #fff;
        }

        .players-body {
            background-color: #fff;
            color: #333;
        }

        .player-cell {
            color: #333 !important;
        }

        .table {
            color: #333;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table thead th {
            color: #333 !important;
        }

        .table tbody td {
            color: #333 !important;
        }
    </style>
</x-app-layout>
