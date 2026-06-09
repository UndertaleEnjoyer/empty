<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ Добавить игрока</h2>
    </x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-football text-white py-4">
                    <h5 class="m-0">
                        <i class="bi bi-person-plus"></i> Форма добавления игрока
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                <i class="bi bi-exclamation-triangle"></i> Ошибка валидации!
                            </strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('players.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="teamId" class="form-label fw-semibold">
                                <i class="bi bi-shield"></i> Команда
                            </label>
                            <select name="team_id" id="teamId" class="form-select form-select-lg @error('team_id') is-invalid @enderror">
                                <option value="">-- Выберите команду --</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="fullName" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Полное имя
                            </label>
                            <input type="text" name="full_name" id="fullName" class="form-control form-control-lg @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name') }}" placeholder="Введите полное имя" required>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="position" class="form-label fw-semibold">
                                <i class="bi bi-dribbble"></i> Позиция
                            </label>
                            <input type="text" name="position" id="position" class="form-control form-control-lg @error('position') is-invalid @enderror"
                                   value="{{ old('position') }}" placeholder="Например: Вратарь, Защитник, Полузащитник, Нападающий" required>
                            @error('position')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                                <i class="bi bi-check-circle"></i> Сохранить
                            </button>
                            <a href="{{ route('players.index') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Отмена
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
    </style>
</x-app-layout>
