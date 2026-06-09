<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold text-dark m-0">⚽ Матчи и результаты</h2>
    </x-slot>

    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h4 fw-bold">Управление матчами</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('matches.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-lg"></i> Создать матч
            </a>
        </div>
    </div>

    <!-- Pagination Settings -->
    <div class="row mb-4">
        <div class="col-md-3">
            <form method="GET" action="{{ route('matches.index') }}" class="d-flex gap-2">
                <label for="perPage" class="col-form-label fw-semibold">Элементов на странице:</label>
                <select name="per_page" id="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Matches Grid -->
    <div class="matches-grid">
        @forelse($matches as $match)
            <div class="match-card-wrapper">
                <div class="card match-card h-100 border-0 overflow-hidden">
                    <div class="match-card-header text-white">
                        <div class="team-section team-left">
                            <h5 class="team-name">{{ $match->team1->name }}</h5>
                        </div>
                        <div class="vs-badge">VS</div>
                        <div class="team-section team-right">
                            <h5 class="team-name">{{ $match->team2->name }}</h5>
                        </div>
                    </div>
                    <div class="card-body match-body p-0">
                        <div class="score-section">
                            <div class="score-display">
                                <span class="score-number team1-score">{{ $match->goals->filter(fn($g) => $g->player->team_id == $match->team1_id)->count() }}</span>
                                <span class="score-separator">:</span>
                                <span class="score-number team2-score">{{ $match->goals->filter(fn($g) => $g->player->team_id == $match->team2_id)->count() }}</span>
                            </div>
                        </div>

                        <div class="match-details">
                            @if($match->date)
                                <div class="detail-item">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ $match->date->format('d.m.Y') }} в {{ $match->date->format('H:i') }}</span>
                                </div>
                            @endif

                            @if($match->venue)
                                <div class="detail-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ $match->venue }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer match-footer border-0 p-3">
                        <a href="{{ route('matches.show', $match->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                            <i class="bi bi-eye"></i> Подробнее
                        </a>
                        <div class="action-buttons">
                            <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('matches.destroy', $match->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Вы уверены?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-inbox display-4 text-muted mb-3" style="display: block;"></i>
                        <p class="text-muted mb-4">Матчей не найдено</p>
                        <a href="{{ route('matches.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Создать первый матч
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $matches->links() }}
    </div>

    <style>
    h1.h4 {
        color: #ffffff !important;
    }

    .col-form-label {
        color: #ffffff !important;
    }

    .matches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .match-card {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-radius: 16px !important;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(26, 71, 42, 0.1);
    }

    .match-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(26, 71, 42, 0.25);
    }

    .match-card-header {
        background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 3px solid rgba(74, 222, 128, 0.3);
    }

    .team-section {
        flex: 1;
        text-align: center;
    }

    .team-name {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff !important;
        word-wrap: break-word;
    }

    .vs-badge {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(74, 222, 128, 0.4);
        color: white !important;
        font-weight: 700;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .match-body {
        background-color: #ffffff !important;
        padding: 1.5rem !important;
    }

    .score-section {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .score-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .score-number {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1;
    }

    .team1-score { color: #3b82f6; }
    .team2-score { color: #10b981; }

    .score-separator {
        font-size: 3rem;
        font-weight: 800;
        color: #1a472a;
    }

    .match-details {
        width: 100%;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        color: #555 !important;
        margin-bottom: 0.5rem;
    }

    .detail-item i {
        color: #1a472a;
    }

    .match-footer {
        background: #f9fafb !important;
        border-top: 1px solid #e0e0e0 !important;
        padding: 1rem 1.5rem !important;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .action-buttons form,
    .action-buttons a {
        flex: 1;
    }

    .action-buttons .btn {
        width: 100%;
    }

    @media (max-width: 768px) {
        .matches-grid {
            grid-template-columns: 1fr;
        }

        .score-number { font-size: 3rem; }
        .score-separator { font-size: 2rem; }
    }
</style>
</x-app-layout>
