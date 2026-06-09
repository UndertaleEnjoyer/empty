<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="h3 fw-bold m-0">
                <i class="bi bi-speedometer2 text-success me-2"></i> Панель управления
            </h2>
        </div>
    </x-slot>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100 card-hover">
                <div class="card-body text-center py-5">
                    <div class="display-icon mb-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="card-title fw-bold">Игроки</h5>
                    <p class="card-text text-muted small mb-3">Управление игроками</p>
                    <a href="{{ route('players.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Перейти
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100 card-hover">
                <div class="card-body text-center py-5">
                    <div class="display-icon mb-3 text-success">
                        <i class="bi bi-shield-fill"></i>
                    </div>
                    <h5 class="card-title fw-bold">Команды</h5>
                    <p class="card-text text-muted small mb-3">Просмотр команд</p>
                    <a href="{{ route('teams.index') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-arrow-right me-1"></i> Перейти
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100 card-hover">
                <div class="card-body text-center py-5">
                    <div class="display-icon mb-3 text-info">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <h5 class="card-title fw-bold">Матчи</h5>
                    <p class="card-text text-muted small mb-3">История и результаты</p>
                    <a href="{{ route('matches.index') }}" class="btn btn-sm btn-info">
                        <i class="bi bi-arrow-right me-1"></i> Перейти
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100 card-hover">
                <div class="card-body text-center py-5">
                    <div class="display-icon mb-3 text-warning">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="card-title fw-bold">Статистика</h5>
                    <p class="card-text text-muted small mb-3">Общая статистика</p>
                    <button class="btn btn-sm btn-warning" disabled>
                        Скоро
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-football text-white">
                    <h5 class="m-0">
                        <i class="bi bi-person-badge me-2"></i> Последние добавленные игроки
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $latestPlayers = \App\Models\Player::latest('created_at')->limit(5)->get();
                    @endphp

                    @if($latestPlayers->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestPlayers as $player)
                                <div class="list-group-item px-0 py-3 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="mb-1 fw-semibold">{{ $player->full_name }}</h6>
                                            <p class="text-muted small mb-0">
                                                @if($player->team)
                                                    <span class="badge bg-info">{{ $player->team->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Без команды</span>
                                                @endif
                                                <span class="badge bg-secondary ms-1">{{ $player->position }}</span>
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('players.show', $player->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('players.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-list me-2"></i> Все игроки
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-3" style="opacity: 0.5;"></i>
                            <p>Игроки еще не добавлены</p>
                            <a href="{{ route('players.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i> Добавить игрока
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-football text-white">
                    <h5 class="m-0">
                        <i class="bi bi-calendar2-check me-2"></i> Последние матчи
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $latestMatches = \App\Models\MatchModel::with('team1', 'team2', 'goals')
                            ->latest('date')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($latestMatches->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestMatches as $match)
                                <div class="list-group-item px-0 py-3 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <p class="mb-1 fw-semibold">
                                                {{ $match->team1->name }}
                                                <span class="badge bg-primary">{{ $match->goals->filter(fn($g) => $g->player->team_id == $match->team1_id)->count() }}</span>
                                                <span class="mx-2 text-muted">-</span>
                                                <span class="badge bg-success">{{ $match->goals->filter(fn($g) => $g->player->team_id == $match->team2_id)->count() }}</span>
                                                {{ $match->team2->name }}
                                            </p>
                                            @if($match->date)
                                                <p class="text-muted small mb-0">
                                                    <i class="bi bi-calendar-event"></i> {{ $match->date->format('d.m.Y H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="{{ route('matches.show', $match->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('matches.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-list me-2"></i> Все матчи
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-3" style="opacity: 0.5;"></i>
                            <p>Матчи еще не добавлены</p>
                            <a href="{{ route('matches.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i> Создать матч
                            </a>
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

    .display-icon {
        font-size: 3rem;
        color: #1a472a;
    }

    .card-hover {
        background: rgba(255, 255, 255, 0.95) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .card-hover .card-title {
        color: #1a472a !important;
    }

    .card-hover .card-text {
        color: #666 !important;
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.25) !important;
    }

    .card-header {
        background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%) !important;
    }

    .card-header h5,
    .card-header * {
        color: #ffffff !important;
    }

    .list-group-item {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left-color: #1a472a;
    }

    .badge {
        font-weight: 600;
        padding: 0.4rem 0.6rem;
    }

    @media (max-width: 768px) {
        .display-icon {
            font-size: 2.5rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
</style>
</x-app-layout>
