<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Footbik') }} - Управление футбольной командой</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            overflow-x: hidden;
        }

        .hero-bg {
            background: linear-gradient(135deg, #0a2c1f 0%, #1a472a 50%, #2d5f3f 100%),
                        url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=1600&h=900&fit=crop&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(74, 222, 128, 0.08), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08), transparent 50%);
            pointer-events: none;
        }

        .navbar-brand-wrapper {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-football {
            background: linear-gradient(90deg, rgba(26, 71, 42, 0.98) 0%, rgba(45, 95, 63, 0.98) 100%) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-bottom: 2px solid rgba(74, 222, 128, 0.2);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-text {
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            font-weight: 500;
            margin-bottom: 3rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 5rem;
        }

        .btn-hero {
            padding: 14px 40px;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
        }

        .btn-hero-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(74, 222, 128, 0.4);
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-4px);
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            width: 100%;
            max-width: 1200px;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            color: white;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(74, 222, 128, 0.8), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.05) 100%);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3), 0 0 30px rgba(74, 222, 128, 0.1);
            border-color: rgba(74, 222, 128, 0.3);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #fff;
        }

        .feature-text {
            font-size: 1rem;
            opacity: 0.85;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-buttons {
                gap: 1rem;
            }

            .btn-hero {
                padding: 12px 32px;
                font-size: 0.95rem;
            }

            .feature-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-football">
        <div class="container-fluid px-4 py-3">
            <a class="navbar-brand navbar-brand-wrapper" href="#">
                <i class="bi bi-dribbble" style="color: #4ade80;"></i> Footbik
            </a>
            @if (Route::has('login'))
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-speedometer2"></i> Панель управления
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-door-open"></i> Вход
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-person-plus"></i> Регистрация
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </nav>

    <div class="hero-bg">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Footbik</h1>
                <p class="hero-subtitle">
                    Профессиональное управление футбольной командой
                </p>

                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('players.index') }}" class="btn-hero btn-hero-primary">
                            <i class="bi bi-people-fill"></i> Игроки
                        </a>
                        <a href="{{ route('teams.index') }}" class="btn-hero btn-hero-primary">
                            <i class="bi bi-shield-check"></i> Команды
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                            <i class="bi bi-door-open"></i> Вход в систему
                        </a>
                        <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                            <i class="bi bi-person-plus"></i> Создать аккаунт
                        </a>
                    @endauth
                </div>

                <div class="features-container">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Управление командами</h3>
                        <p class="feature-text">Создавайте команды, управляйте составом и отслеживайте производительность каждого игрока в реальном времени</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="feature-title">Учет игроков</h3>
                        <p class="feature-text">Полная база данных игроков с информацией о позициях, достижениях и участии в матчах</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h3 class="feature-title">История матчей</h3>
                        <p class="feature-text">Ведите полный учет всех матчей, результатов и статистики голов для анализа производительности</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
