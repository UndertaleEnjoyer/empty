<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Footbik') }} - Восстановление пароля</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        .forgot-password-wrapper {
            background: linear-gradient(135deg, #0a2c1f 0%, #1a472a 50%, #0f3a25 100%);
            background-image:
                linear-gradient(135deg, rgba(10, 44, 31, 0.92) 0%, rgba(26, 71, 42, 0.92) 100%),
                url('https://images.unsplash.com/photo-1517466895681-8ac85a1f0dec?w=1200&h=800&fit=crop&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .forgot-card {
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 0;
            overflow: hidden;
        }

        .forgot-card-header {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 50%, #1a7d3d 100%);
            border-bottom: 5px solid #fff;
        }

        .forgot-card-header .h2 {
            margin: 0;
            font-weight: 700;
        }

        .forgot-input {
            border-radius: 8px;
            border: 2px solid #27ae60;
            transition: all 0.3s ease;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            background-color: #f0f8f5;
        }

        .forgot-input:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.25);
            background-color: #fff;
        }

        .forgot-btn {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 0.75rem 1rem;
        }

        .forgot-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(39, 174, 96, 0.3);
            background: linear-gradient(135deg, #1e8449 0%, #1a7d3d 100%);
            color: white;
        }

        .forgot-back-btn {
            color: #27ae60;
            border: 2px solid #27ae60;
            font-weight: 600;
        }

        .forgot-back-btn:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .alert-success {
            background-color: #d5f4e6;
            border-color: #27ae60;
            color: #1e8449;
        }
    </style>
</head>
<body class="forgot-password-wrapper">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card forgot-card">
                        <div class="forgot-card-header text-center py-5 text-white">
                            <h2 class="h2 fw-bold">Footbik</h2>
                            <p class="lead mb-0">Восстановление пароля</p>
                        </div>

                        <div class="card-body p-5">
                            <p class="text-muted mb-4">
                                Забыли пароль? Не проблема. Просто укажите свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля.
                            </p>

                            @session('status')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle"></i> {{ $value }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endsession

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

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label">Email адрес</label>
                                    <input id="email" type="email" class="form-control form-control-lg forgot-input @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                           placeholder="Введите ваш email">
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-lg forgot-btn w-100 mb-3">
                                    <i class="bi bi-envelope"></i> Отправить ссылку для сброса
                                </button>
                            </form>

                            <div class="text-center border-top pt-3">
                                <a href="{{ route('login') }}" class="btn btn-sm forgot-back-btn fw-bold mt-2">
                                    <i class="bi bi-arrow-left"></i> Вернуться к входу
                                </a>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-white mt-4 small">
                        © 2026 Footbik. Все права защищены.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
