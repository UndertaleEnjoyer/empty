<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Footbik') }} - Управление футбольной командой</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-football sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('dashboard') }}">
                    <i class="bi bi-dribbble" style="color: #4ade80;"></i> {{ config('app.name', 'Footbik') }}
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('players.index') }}">
                    <i class="bi bi-person-check"></i> Игроки
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teams.index') }}">
                    <i class="bi bi-shield-check"></i> Команды
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('matches.index') }}">
                    <i class="bi bi-calendar-event"></i> Матчи
                </a>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
               href="#"
               id="userDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">

                <i class="bi bi-person-circle"></i>
                {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                aria-labelledby="userDropdown">

                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2"></i>
                        Профиль
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Панель управления
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Выйти из аккаунта
                        </button>
                    </form>
                </li>
            </ul>
        </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Вход</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            </li>
        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="app-background">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="page-header">
                    <div class="container">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Flash Messages -->
            @if ($message = Session::get('success'))
                <div class="container mt-4">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="container mt-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($message = Session::get('warning'))
                <div class="container mt-4">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="container py-4">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @livewireScripts

        <style>
            .navbar-football {
                background: linear-gradient(90deg, #1a472a 0%, #2d5f3f 100%);
                box-shadow: 0 4px 12px rgba(26, 71, 42, 0.25);
                border-bottom: 2px solid rgba(74, 222, 128, 0.2);
            }

            .app-background {
        background: linear-gradient(135deg, #1a3d28 0%, #0d2218 60%, #0a1e12 100%);
        min-height: 100vh;
    }

    body {
        background-color: #0a1e12;
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

            .page-header {
                background: linear-gradient(135deg, rgba(26, 71, 42, 0.95) 0%, rgba(45, 95, 63, 0.95) 100%);
                color: white;
                box-shadow: 0 2px 8px rgba(26, 71, 42, 0.15);
                border-bottom: 3px solid #4ade80;
                padding: 2rem 0;
            }

            .page-header h2 {
                color: white !important;
            }

            .card {
                border-radius: 12px;
                border: none;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(26, 71, 42, 0.12);
            }

            .btn {
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .btn-primary {
                background-color: #1a472a;
                border-color: #1a472a;
            }

            .btn-primary:hover {
                background-color: #2d5f3f;
                border-color: #2d5f3f;
            }

            .table th {
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                background-color: rgba(26, 71, 42, 0.08);
                border-bottom: 2px solid #1a472a;
            }

            .badge {
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
                font-weight: 500;
                border-radius: 6px;
            }

            h1, h2, h3, h4, h5, h6 {
                color: #1a472a;
            }

            .alert {
                border-radius: 8px;
                border: none;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .form-control, .form-select {
                border-radius: 6px;
                border: 1.5px solid #e0e0e0;
                transition: all 0.3s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: #1a472a;
                box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15);
                background-color: #fff;
            }

            .shadow-sm {
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08) !important;
            }

            .shadow-lg {
                box-shadow: 0 8px 16px rgba(26, 71, 42, 0.1) !important;
            }

            @media (max-width: 768px) {
                .page-header {
                    padding: 1.5rem 0;
                }

                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            }
        </style>
    </body>
</html>
