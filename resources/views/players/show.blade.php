<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ {{ $player->full_name }}</h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 mb-4 player-card">
                <div class="card-header bg-gradient-football text-white py-4">
                    <h5 class="m-0">
                        <i class="bi bi-person-badge"></i> Информация об игроке
                    </h5>
                </div>
                <div class="card-body player-info-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="player-label mb-2">Полное имя</h6>
                            <h5 class="fw-bold player-name">{{ $player->full_name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="player-label mb-2">Позиция</h6>
                            <span class="badge bg-info fs-6">{{ $player->position }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="player-label mb-2">Команда</h6>
                            @if($player->team)
                                <span class="badge bg-success fs-6">{{ $player->team->name }}</span>
                            @else
                                <span class="player-text-muted">Не назначена</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 matches-card">
                <div class="card-header bg-gradient-football text-white py-4">
                    <h5 class="m-0">
                        <i class="bi bi-soccer"></i> Матчи игрока
                    </h5>
                </div>
                <div class="card-body matches-body">
                    @if($player->matches->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="bi bi-calendar-event"></i> № Матча</th>
                                        <th><i class="bi bi-clock"></i> Минута гола</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($player->matches as $match)
                                        <tr>
                                            <td>
                                                <a href="{{ route('matches.show', $match->id) }}" class="fw-bold text-decoration-none match-link">
                                                    Матч #{{ $match->id }}
                                                </a>
                                            </td>
                                            <td class="match-minute">{{ $match->pivot->minute }}'</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> Игрок еще не участвовал в матчах
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center gap-2">
        <a href="{{ route('players.index') }}" class="btn btn-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Вернуться к списку
        </a>
        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-lg">
            <i class="bi bi-pencil"></i> Редактировать
        </a>
    </div>

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .player-card {
            background-color: #fff;
        }

        .player-info-body {
            background-color: #fff;
            color: #333;
        }

        .player-label {
            color: #666 !important;
            font-weight: 600;
        }

        .player-name {
            color: #1a472a !important;
        }

        .player-text-muted {
            color: #666 !important;
        }

        .matches-card {
            background-color: #fff;
        }

        .matches-body {
            background-color: #fff;
            color: #333;
        }

        .match-link {
            color: #1a472a !important;
        }

        .match-minute {
            color: #666 !important;
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
