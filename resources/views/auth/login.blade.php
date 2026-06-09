<x-guest-layout>
    <div class="auth-page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-5 col-lg-4">
                    <div class="card auth-card shadow-xl border-0 overflow-hidden">
                        <div class="auth-card-header bg-gradient-success">
                            <div class="text-center py-5 text-white">
                                <h2 class="h2 fw-bold">Footbik</h2>
                                <p class="lead">Вход в систему</p>
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

                            @session('status')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle"></i> {{ $value }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endsession

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold text-dark">Email адрес</label>
                                    <input id="email" type="email" class="form-control form-control-lg auth-input @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                           placeholder="Введите ваш email">
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold text-dark">Пароль</label>
                                    <input id="password" type="password" class="form-control form-control-lg auth-input @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password"
                                           placeholder="Введите ваш пароль">
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="rememberMe" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMe">
                                            Запомнить меня
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-lg btn-vibrant w-100 fw-bold py-3 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Вход
                                </button>
                            </form>

                            <div class="divider-text my-4">или</div>

                            <div class="text-center mb-4">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary fw-semibold d-block mb-2">
                                        <i class="bi bi-key"></i> Забыли пароль?
                                    </a>
                                @endif
                            </div>

                            <div class="text-center py-3 border-top">
                                <p class="text-muted mb-0">Нет аккаунта?</p>
                                <a href="{{ route('register') }}" class="btn btn-outline-vibrant btn-sm mt-2 fw-bold">
                                    <i class="bi bi-person-plus"></i> Зарегистрироваться
                                </a>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-muted mt-4 small">
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

        .divider-text {
            text-align: center;
            color: #999;
            font-size: 0.9rem;
        }

        .card-body {
    color: #333 !important;
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

        .auth-card .card-body {
    background-color: #ffffff !important;
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

        .card {
            border-radius: 16px;
        }

        .shadow-xl {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        }

        .min-vh-100 {
            min-height: 100vh;
        }
    </style>
</x-guest-layout>
