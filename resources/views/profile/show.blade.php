<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="h3 fw-bold m-0">
                <i class="bi bi-person-circle text-success me-2"></i> Профиль
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-football text-white">
                        <h5 class="m-0 fw-bold">
                            <i class="bi bi-person me-2"></i> Информация профиля
                        </h5>
                    </div>
                    <div class="card-body">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-football text-white">
                        <h5 class="m-0 fw-bold">
                            <i class="bi bi-key me-2"></i> Обновить пароль
                        </h5>
                    </div>
                    <div class="card-body">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-football text-white">
                        <h5 class="m-0 fw-bold">
                            <i class="bi bi-shield-check me-2"></i> Двухфакторная аутентификация
                        </h5>
                    </div>
                    <div class="card-body">
                        <livewire:profile.two-factor-authentication-form />
                    </div>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-football text-white">
                    <h5 class="m-0 fw-bold">
                        <i class="bi bi-window me-2"></i> Сеансы браузера
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:profile.logout-other-browser-sessions-form />
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="card shadow-sm border-0 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="m-0 fw-bold">
                            <i class="bi bi-trash me-2"></i> Удалить аккаунт
                        </h5>
                    </div>
                    <div class="card-body">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-gradient-football {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
        }

        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(26, 71, 42, 0.12) !important;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            border: none;
        }

        .card-body {
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            h5 {
                font-size: 1.1rem;
            }
        }
    </style>
</x-app-layout>
