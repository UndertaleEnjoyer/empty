<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ Создать новый матч</h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('matches.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Вернуться к списку
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-football text-white py-3">
                    <h5 class="m-0"><i class="bi bi-plus-circle"></i> Информация о матче</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('matches.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="team1_id" class="form-label fw-semibold">
                                <i class="bi bi-shield"></i> Первая команда
                            </label>
                            <select name="team1_id" id="team1_id" class="form-select form-select-lg" required>
                                <option value="">-- Выберите команду --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team1_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team1_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="team2_id" class="form-label fw-semibold">
                                <i class="bi bi-shield"></i> Вторая команда
                            </label>
                            <select name="team2_id" id="team2_id" class="form-select form-select-lg" required>
                                <option value="">-- Выберите команду --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team2_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team2_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event"></i> Дата и время матча
                            </label>
                            <input type="datetime-local" name="date" id="date" class="form-control form-control-lg"
                                   value="{{ old('date', '') }}" required>
                            @error('date')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="venue" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt"></i> Место проведения
                            </label>
                            <input type="text" name="venue" id="venue" class="form-control form-control-lg" 
                                   placeholder="Например: Стадион Динамо, Поле №1" 
                                   value="{{ old('venue') }}" required>
                            @error('venue')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-semibold">
                                <i class="bi bi-check-lg"></i> Создать матч
                            </button>
                            <a href="{{ route('matches.index') }}" class="btn btn-outline-secondary btn-lg">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1a472a;
            box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15);
        }

        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
        }
    </style>
</x-app-layout>
