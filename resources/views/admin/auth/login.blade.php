<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin — Mimosa </title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Bootstrap 5 (local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Google Fonts (local) -->
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: #0d1f33;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 30px 80px rgba(0,0,0,.4);
        }
        .login-card .logo { text-align: center; margin-bottom: 2rem; }
        .login-card .logo img { height: 70px; }
        .login-card h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            color: #1a3a5c;
            text-align: center;
            margin-bottom: .4rem;
        }
        .login-card .subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: .85rem;
            margin-bottom: 2rem;
        }
        .form-label { font-weight: 600; font-size: .85rem; color: #475569; }
        .form-control {
            padding: .75rem 1rem;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #c8a84b;
            box-shadow: 0 0 0 .2rem rgba(200,168,75,.2);
        }
        .btn-login {
            background: #1a3a5c;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            padding: .85rem;
            border-radius: 8px;
            border: none;
            width: 100%;
            font-size: .95rem;
            letter-spacing: .5px;
            transition: all .3s;
        }
        .btn-login:hover {
            background: #c8a84b;
            color: #0d1f33;
        }
        .input-icon { position: relative; }
        .input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .input-icon input { padding-left: 2.8rem; }
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a { color: #c8a84b; text-decoration: none; font-size: .85rem; }
        .back-link a:hover { color: #1a3a5c; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="logo">
        <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Mimosa ">
    </div>
    <h2>Administration</h2>
    <p class="subtitle">Connectez-vous pour accéder au panneau de gestion</p>

    @if(session('success'))
        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Adresse Email</label>
            <div class="input-icon">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}"
                       placeholder="admin@mimosaflour.com"
                       required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Mot de passe</label>
            <div class="input-icon">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
        </div>
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Se souvenir de moi</label>
            </div>
        </div>
        <button type="submit" class="btn-login">
            <i class="bi bi-shield-lock-fill me-2"></i>Se connecter
        </button>
    </form>

    <div class="back-link">
        <a href="{{ route('home') }}">
            <i class="bi bi-arrow-left me-1"></i>Retour au site
        </a>
    </div>
</div>

<!-- Bootstrap JS (local) -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
