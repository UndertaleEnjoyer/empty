<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">
            <i class="bi bi-calendar-event-fill"></i> Матч: {{ $match->team1->name }} vs {{ $match->team2->name }}
        </h2>
    </x-slot>

    <div class="mb-4 d-flex justify-content-center gap-2">
        <a href="{{ route('matches.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Вернуться к списку
        </a>
        <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Редактировать
        </a>
    </div>

    <!-- Match Score Card -->
    <div class="card shadow-lg border-0 mb-4 match-score-card">
        <div class="card-header bg-gradient-football text-white py-4">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <h4 class="m-0 fw-bold">{{ $match->team1->name }}</h4>
                </div>
                <div class="col-md-4 text-center">
                    <div class="display-2 fw-bold text-white">
                        {{ $teamStats['team1'] }}<span class="mx-3">:</span>{{ $teamStats['team2'] }}
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <h4 class="m-0 fw-bold">{{ $match->team2->name }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body p-4 match-info-body">
            <div class="row text-center">
                @if($match->date)
                    <div class="col-md-6">
                        <p class="match-label mb-1">Дата матча</p>
                        <p class="fw-semibold match-value">
                            <i class="bi bi-calendar-event"></i> {{ $match->date->format('d.m.Y H:i') }}
                        </p>
                    </div>
                @endif
                @if($match->venue)
                    <div class="col-md-6">
                        <p class="match-label mb-1">Место проведения</p>
                        <p class="fw-semibold match-value">
                            <i class="bi bi-geo-alt"></i> {{ $match->venue }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Goals Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4 goals-card">
                <div class="card-header bg-success text-white">
                    <h5 class="m-0"><i class="bi bi-trophy"></i> Голы</h5>
                </div>
                <div class="card-body goals-body">
                    @if($match->goals->count() > 0)
                        <div class="goals-list">
                            @foreach($match->goals->sortBy('minute') as $goal)
                                <div class="goal-item p-3 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <span class="badge bg-primary">{{ $goal->minute }}'</span>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="m-0 fw-semibold goal-player-name">
                                                <a href="{{ route('players.show', $goal->player->id) }}" class="text-decoration-none">
                                                    {{ $goal->player->full_name }}
                                                </a>
                                            </p>
                                            <p class="m-0 goal-team small">
                                                <i class="bi bi-shield"></i> {{ $goal->player->team->name }}
                                            </p>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить гол?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="goal-empty text-center py-5 mb-0">
                            <i class="bi bi-inbox"></i> В этом матче еще не было голов
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Add Goal Form -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 add-goal-card">
                <div class="card-header bg-info text-white">
                    <h5 class="m-0"><i class="bi bi-plus-circle"></i> Добавить гол</h5>
                </div>
                <div class="card-body add-goal-body">
                    <form action="{{ route('matches.addGoal', $match->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="player_id" class="form-label fw-semibold">Игрок</label>
                            <select name="player_id" id="player_id" class="form-select" required>
                                <option value="">-- Выберите игрока --</option>
                                <optgroup label="{{ $match->team1->name }}">
                                    @foreach($match->team1->players as $player)
                                        <option value="{{ $player->id }}">{{ $player->full_name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="{{ $match->team2->name }}">
                                    @foreach($match->team2->players as $player)
                                        <option value="{{ $player->id }}">{{ $player->full_name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('player_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="minute" class="form-label fw-semibold">Минута</label>
                            <input type="number" name="minute" id="minute" class="form-control" min="0" max="120" required>
                            @error('minute')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-lg"></i> Добавить гол
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm border-0 mt-3 stats-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="m-0"><i class="bi bi-bar-chart"></i> Статистика</h5>
                </div>
                <div class="card-body stats-body">
                    <div class="stat-item p-2 mb-3">
                        <p class="stat-label small mb-1">{{ $match->team1->name }}</p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: {{ $teamStats['team1'] * 20 }}%">
                                {{ $teamStats['team1'] }}
                            </div>
                        </div>
                    </div>
                    <div class="stat-item p-2">
                        <p class="stat-label small mb-1">{{ $match->team2->name }}</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $teamStats['team2'] * 20 }}%">
                                {{ $teamStats['team2'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .match-header-score {
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 2rem 1rem;
        }

        .team-section {
            flex: 1;
            text-align: center;
        }

        .score-separator {
            color: white;
            font-size: 3rem;
            font-weight: bold;
            padding: 0 2rem;
        }

        .match-score-card {
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .match-info-body {
            background-color: #fff;
            color: #333;
        }

        .match-label {
            color: #666 !important;
            font-weight: 600;
        }

        .match-value {
            color: #1a472a !important;
        }

        .goals-card {
            background-color: #fff;
        }

        .goals-body {
            background-color: #fff;
            color: #333;
        }

        .goal-item {
            position: relative;
            padding-left: 2rem;
            border-left: 3px solid #1a472a;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .goal-item:hover {
            background-color: #f0f7f4;
            border-left-color: #e74c3c;
        }

        .goal-item:last-child {
            border-bottom: none !important;
        }

        .goal-player-name {
            color: #1a472a !important;
        }

        .goal-player-name a {
            color: #1a472a !important;
        }

        .goal-team {
            color: #666 !important;
        }

        .goal-empty {
            color: #999 !important;
        }

        .goal-minute {
            position: absolute;
            left: -10px;
            top: 1rem;
            width: 20px;
            height: 20px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.7rem;
        }

        .add-goal-card {
            background-color: #fff;
        }

        .add-goal-body {
            background-color: #fff;
            color: #333;
        }

        .stats-card {
            background-color: #fff;
        }

        .stats-body {
            background-color: #fff;
            color: #333;
        }

        .stat-label {
            color: #666 !important;
            font-weight: 600;
        }

        .progress {
            height: 1.5rem;
            background-color: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 0.3s ease;
        }

        .card-header {
            border-bottom: none;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-buttons .btn {
            flex: 1;
        }
    </style>
</x-app-layout>
