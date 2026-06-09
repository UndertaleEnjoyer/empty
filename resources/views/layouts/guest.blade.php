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

    <style>
        body {
            background: linear-gradient(135deg, #0a2c1f 0%, #1a472a 50%, #2d5f3f 100%),
                        url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=1600&h=900&fit=crop&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Figtree', sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(74, 222, 128, 0.05), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.05), transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .guest-container {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .card {
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 2.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            border: none;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(74, 222, 128, 0.4);
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus, .form-select:focus {
            border-color: #4ade80;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 0.3rem rgba(74, 222, 128, 0.25);
            color: white;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        h2 {
            color: white;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        a {
            color: #4ade80;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #22c55e;
            text-decoration: underline;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .alert {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: white;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="guest-container">
        {{ $slot }}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts
</body>
</html>
