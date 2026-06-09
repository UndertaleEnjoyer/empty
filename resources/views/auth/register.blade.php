<x-guest-layout>
    <div class="auth-page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-5 col-lg-4">
                    <div class="card auth-card shadow-xl border-0 overflow-hidden">
                        <div class="auth-card-header bg-gradient-success">
                            <div class="text-center py-5 text-white">
                                <h2 class="h2 fw-bold">Footbik</h2>
                                <p class="lead">Создать аккаунт</p>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="bi bi-exclamation-triangle"></i> Ошибка!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold text-dark">Полное имя</label>
                                    <input id="name" type="text" class="form-control form-control-lg auth-input @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                           placeholder="Введите ваше имя">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold text-dark">Email адрес</label>
                                    <input id="email" type="email" class="form-control form-control-lg auth-input @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="username"
                                           placeholder="Введите ваш email">
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold text-dark">Пароль</label>
                                    <input id="password" type="password" class="form-control form-control-lg auth-input @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="new-password"
                                           placeholder="Введите пароль">
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="passwordConfirmation" class="form-label fw-bold text-dark">Подтвердите пароль</label>
                                    <input id="passwordConfirmation" type="password" class="form-control form-control-lg auth-input @error('password_confirmation') is-invalid @enderror"
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="Повторите пароль">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                                   type="checkbox" name="terms" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                Я согласен с
                                                @if (Route::has('terms.show'))
                                                    <a href="{{ route('terms.show') }}" target="_blank" class="text-decoration-none text-vibrant fw-semibold">
                                                        условиями использования
                                                    </a>
                                                @endif
                                                и
                                                @if (Route::has('policy.show'))
                                                    <a href="{{ route('policy.show') }}" target="_blank" class="text-decoration-none text-vibrant fw-semibold">
                                                        политикой конфиденциальности
                                                    </a>
                                                @endif
                                            </label>
                                            @error('terms')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-lg btn-vibrant w-100 fw-bold py-3 mb-3">
                                    <i class="bi bi-person-plus"></i> Зарегистрироваться
                                </button>
                            </form>

                            <div class="text-center py-3 border-top">
                                <p class="text-muted mb-0">Уже зарегистрированы?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-vibrant btn-sm mt-2 fw-bold">
                                    <i class="bi bi-box-arrow-in-right"></i> Вход
                                </a>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-white mt-4 small">
                        © 2026 {{ config('app.name') }}. Все права защищены.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-page-wrapper {
            background: linear-gradient(135deg, #0a2c1f 0%, #1a472a 50%, #0f3a25 100%);
            background-image:
                linear-gradient(135deg, rgba(10, 44, 31, 0.92) 0%, rgba(26, 71, 42, 0.92) 100%),
                url('https://images.unsplash.com/photo-1517466895681-8ac85a1f0dec?w=1200&h=800&fit=crop&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .auth-card {
            border-radius: 16px;
            max-width: 100%;
        }

        .auth-card-header {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 50%, #1a7d3d 100%);
            border-bottom: 5px solid #fff;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 50%, #1a7d3d 100%) !important;
        }

        .auth-input {
            border-radius: 8px;
            border: 2px solid #27ae60;
            transition: all 0.3s ease;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            background-color: #f0f8f5;
        }

        .auth-input:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.25);
            background-color: #fff;
        }

        .btn-vibrant {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-vibrant:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(39, 174, 96, 0.3);
            background: linear-gradient(135deg, #1e8449 0%, #1a7d3d 100%);
            color: white;
        }

        .btn-outline-vibrant {
            color: #27ae60;
            border: 2px solid #27ae60;
        }

        .btn-outline-vibrant:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            color: white;
        }

        .text-vibrant {
            color: #27ae60;
        }

        .text-vibrant:hover {
            color: #1e8449;
        }

        .card {
            border-radius: 16px;
        }

        .shadow-xl {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        .form-check-input {
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .card-body {
    color: #333 !important;
    background-color: #ffffff !important;
}

.auth-card .card-body {
    background-color: #ffffff !important;
}

.auth-input {
    color: #1a1a1a !important;
    background-color: #ffffff !important;
}

.auth-input:focus {
    color: #1a1a1a !important;
    background-color: #ffffff !important;
}

.auth-input::placeholder {
    color: #999 !important;
}
        .form-label, .form-check-label {
            color: #333 !important;
        }

        .text-muted {
            color: #666 !important;
        }

        .text-secondary {
            color: #666 !important;
        }

        .text-white {
            color: white !important;
        }
    </style>
</x-guest-layout>
