<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employés — Mimosa Flour</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #0d1f33 0%, #1a3a5c 50%, #0d1f33 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 3rem;
            width: 100%; max-width: 440px;
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
        }
        .login-logo { height: 60px; }
        .brand-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: #1a3a5c;
            font-size: 1.6rem;
        }
        .brand-sub { color: #c8a84b; font-size: .82rem; font-weight: 600; letter-spacing: 2px; }
        .form-control:focus {
            border-color: #c8a84b;
            box-shadow: 0 0 0 .2rem rgba(200,168,75,.2);
        }
        .btn-login {
            background: linear-gradient(135deg, #1a3a5c, #2a5298);
            border: none;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            padding: .75rem;
            border-radius: 8px;
            transition: opacity .2s;
        }
        .btn-login:hover { opacity: .9; color: #fff; }
        .divider { color: #94a3b8; font-size: .8rem; }
        .role-badge {
            display: inline-block;
            padding: .2rem .6rem;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Mimosa" class="login-logo rounded mb-3">
        <div class="brand-name">Mimosa</div>
        <div class="brand-sub">ESPACE EMPLOYÉS</div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3">
            <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('employee.login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">Adresse e-mail</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0 ps-0"
                       value="{{ old('email') }}" placeholder="votre@email.com" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold text-muted small">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-lock text-muted"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0 ps-0"
                       placeholder="••••••••" required>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small text-muted" for="remember">Se souvenir de moi</label>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </button>
    </form>

    <hr class="my-4">
    <div class="text-center">
        <div class="divider mb-2">Modules disponibles</div>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <span class="role-badge" style="background:#dbeafe;color:#1e40af;">Commercial</span>
            <span class="role-badge" style="background:#cffafe;color:#155e75;">Magasinier</span>
            <span class="role-badge" style="background:#f0fdf4;color:#166534;">RH</span>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.login') }}" class="text-muted small text-decoration-none">
            <i class="bi bi-shield-lock me-1"></i>Accès Administrateur
        </a>
    </div>
</div>
</body>
</html>
