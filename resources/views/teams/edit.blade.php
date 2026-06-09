<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 fw-bold m-0">⚽ Редактирование команды</h2>
    </x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-football py-4">
                    <h4 class="card-title m-0 text-white">
                        <i class="bi bi-pencil-square"></i> Редактировать: {{ $team->name }}
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teams.update', $team->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-shield"></i> Название команды
                            </label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $team->name) }}" 
                                   placeholder="Например: Зенит, ЦСКА, Спартак..." required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-check-circle"></i> Сохранить изменения
                            </button>
                            <a href="{{ route('teams.index') }}" class="btn btn-secondary btn-lg">
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
