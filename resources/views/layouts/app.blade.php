<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mimosa  - Leader de la production de farine au Cameroun. Farine de qualité supérieure pour professionnels et particuliers.">
    <meta name="keywords" content="farine, minoterie, Mimosa , Cameroun, Douala, blé, production farine">
    <title>@yield('title', 'Mimosa ') - Qualité & Excellence</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Bootstrap 5 CSS (local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Google Fonts (local) -->
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">
    <!-- AOS Animation (local) -->
    <link href="{{ asset('assets/css/aos.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary:    #1a3a5c;  /* Bleu marine profond */
            --secondary:  #c8a84b;  /* Or / doré - couleur du blé */
            --accent:     #e8f4f8;  /* Bleu très clair */
            --dark:       #0d1f33;
            --light:      #f8f5ef;  /* Beige clair - couleur de la farine */
            --text-dark:  #1a2639;
            --text-muted: #6c757d;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--text-dark);
            background: #fff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* ===== NAVBAR ===== */
        .navbar-main {
            background: var(--primary);
            padding: 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-main .navbar-brand img {
            height: 60px;
            transition: transform 0.3s;
        }
        .navbar-main .navbar-brand img:hover { transform: scale(1.05); }

        .navbar-main .nav-link {
            color: rgba(255,255,255,0.88) !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.88rem;
            letter-spacing: 0.5px;
            padding: 1.2rem 1rem !important;
            text-transform: uppercase;
            transition: color 0.25s, border-bottom 0.25s;
            border-bottom: 3px solid transparent;
        }

        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active {
            color: var(--secondary) !important;
            border-bottom-color: var(--secondary);
        }

        .navbar-main .navbar-toggler { border-color: var(--secondary); }
        .navbar-main .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28200%2C168%2C75%2C1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Topbar */
        .topbar {
            background: var(--dark);
            padding: 7px 0;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
        }
        .topbar a { color: var(--secondary); text-decoration: none; }
        .topbar a:hover { color: #fff; }

        /* ===== HERO / SLIDER ===== */
        .hero-carousel .carousel-item {
            height: 92vh;
            min-height: 500px;
        }
        .hero-carousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.55);
        }
        .hero-carousel .carousel-caption {
            bottom: 50%;
            transform: translateY(50%);
            left: 8%;
            right: 8%;
            text-align: left;
        }
        .hero-carousel .carousel-caption h2 {
            font-size: clamp(2rem, 5vw, 3.8rem);
            font-weight: 800;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            margin-bottom: 1rem;
        }
        .hero-carousel .carousel-caption p {
            font-size: clamp(1rem, 2vw, 1.3rem);
            max-width: 600px;
            margin-bottom: 2rem;
        }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            background: var(--secondary);
            color: var(--dark);
            border: none;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background: #b8962f;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200,168,75,0.4);
        }

        .btn-outline-custom {
            background: transparent;
            color: #fff;
            border: 2px solid var(--secondary);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            padding: 0.7rem 1.8rem;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-outline-custom:hover {
            background: var(--secondary);
            color: var(--dark);
        }

        /* ===== SECTIONS ===== */
        .section-title {
            text-align: center;
            margin-bottom: 3.5rem;
        }
        .section-title .subtitle {
            color: var(--secondary);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 0.5rem;
        }
        .section-title h2 {
            color: var(--primary);
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            position: relative;
            display: inline-block;
            padding-bottom: 0.8rem;
        }
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--secondary);
        }

        /* ===== PRODUCT CARD ===== */
        .product-card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        .product-card img {
            height: 220px;
            object-fit: cover;
        }
        .product-card .card-body { padding: 1.4rem; }
        .product-card .badge-category {
            background: var(--secondary);
            color: var(--dark);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 2px;
            text-transform: uppercase;
        }
        .product-card .card-title {
            font-size: 1.05rem;
            color: var(--primary);
            margin: 0.5rem 0;
        }
        .product-card .price {
            color: var(--secondary);
            font-weight: 800;
            font-size: 1.15rem;
            font-family: 'Montserrat', sans-serif;
        }

        /* ===== STATS / CHIFFRES ===== */
        .stats-section {
            background: var(--primary);
            padding: 4rem 0;
        }
        .stat-item {
            text-align: center;
            color: #fff;
        }
        .stat-item .number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--secondary);
            font-family: 'Montserrat', sans-serif;
            line-height: 1;
        }
        .stat-item .label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0.4rem;
            color: rgba(255,255,255,0.8);
        }

        /* ===== SERVICE CARD ===== */
        .service-card {
            text-align: center;
            padding: 2.5rem 1.5rem;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 3px 20px rgba(0,0,0,0.07);
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        .service-card:hover {
            border-bottom-color: var(--secondary);
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
        }
        .service-card .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), #2a5298);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }
        .service-card .icon i {
            font-size: 1.8rem;
            color: var(--secondary);
        }

        /* ===== JOB CARD ===== */
        .job-card {
            border-left: 4px solid var(--secondary);
            border-radius: 0 8px 8px 0;
            padding: 1.5rem;
            background: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.07);
            transition: all 0.3s;
            margin-bottom: 1rem;
        }
        .job-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            transform: translateX(5px);
        }
        .job-card .job-type {
            background: var(--accent);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--dark);
            color: rgba(255,255,255,0.8);
            padding-top: 4rem;
        }
        footer h5 {
            color: var(--secondary);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.2rem;
        }
        footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        footer a:hover { color: var(--secondary); }
        footer .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 1.2rem 0;
            margin-top: 3rem;
            font-size: 0.83rem;
            text-align: center;
            color: rgba(255,255,255,0.5);
        }
        footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            margin-right: 8px;
            color: #fff;
            transition: all 0.3s;
        }
        footer .social-links a:hover {
            background: var(--secondary);
            color: var(--dark);
        }

        /* ===== MISC ===== */
        .bg-light-custom { background: var(--light); }
        .text-gold { color: var(--secondary); }
        .text-navy { color: var(--primary); }

        .breadcrumb-section {
            background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
            padding: 3rem 0;
            color: #fff;
        }
        .breadcrumb-section h1 { color: #fff; margin-bottom: 0.5rem; }
        .breadcrumb-item a { color: var(--secondary); }
        .breadcrumb-item.active { color: rgba(255,255,255,0.8); }
        .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.5); }

        /* Alert flash */
        .alert-flash {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 420px;
            animation: slideIn 0.4s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-carousel .carousel-item { height: 60vh; }
            .hero-carousel .carousel-caption { text-align: center; left: 5%; right: 5%; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Topbar -->
<div class="topbar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span><i class="bi bi-telephone-fill me-1"></i>
                    <a href="tel:+237620731930">+237 620 731 930</a>
                </span>
                <span class="ms-4"><i class="bi bi-envelope-fill me-1"></i>
                    <a href="mailto:info@mimosaflour.com">info@mimosaflour.com</a>
                </span>
            </div>
            <div class="col-md-6 text-end">
                <i class="bi bi-geo-alt-fill me-1"></i> {{ __('DOUALA, CAMEROUN') }}
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Mimosa  Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">{{ __('Accueil') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">{{ __('À Propos') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">{{ __('Produits') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                       href="{{ route('services') }}">{{ __('Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('careers.*') ? 'active' : '' }}"
                       href="{{ route('careers.index') }}">{{ __('Carrières') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">{{ __('Contact') }}</a>
                </li>
                {{-- Language switcher --}}
                <li class="nav-item ms-lg-2 d-flex align-items-center" style="gap:.15rem; padding:.3rem 0;">
                    <a href="{{ route('locale.switch', 'fr') }}"
                       style="font-size:.72rem; font-weight:700; padding:.18rem .45rem; border-radius:3px; text-decoration:none;
                              color:{{ app()->getLocale()==='fr' ? 'var(--dark)' : 'rgba(255,255,255,.5)' }};
                              background:{{ app()->getLocale()==='fr' ? 'var(--secondary)' : 'transparent' }};">FR</a>
                    <span style="color:rgba(255,255,255,.25); font-size:.7rem;">|</span>
                    <a href="{{ route('locale.switch', 'en') }}"
                       style="font-size:.72rem; font-weight:700; padding:.18rem .45rem; border-radius:3px; text-decoration:none;
                              color:{{ app()->getLocale()==='en' ? 'var(--dark)' : 'rgba(255,255,255,.5)' }};
                              background:{{ app()->getLocale()==='en' ? 'var(--secondary)' : 'transparent' }};">EN</a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link position-relative {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                       href="{{ route('cart.index') }}" title="{{ __('Mon panier') }}">
                        <i class="bi bi-cart3" style="font-size:1.2rem;"></i>
                        @php $cartCount = count(session('mimosa_cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                  style="background:var(--secondary); color:var(--dark); font-size:.6rem; min-width:18px; padding:.25em .4em;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash messages -->
@if(session('success'))
    <div class="alert alert-success alert-flash alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-flash alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Page Content -->
@yield('content')

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row gy-4">
            <!-- Logo & About -->
            <div class="col-lg-4 col-md-6">
                <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Mimosa" height="70"
                     class="mb-3 rounded">
                <p class="small" style="color:rgba(255,255,255,0.65); line-height:1.8;">
                    {{ __('Mimosa  est un leader dans la production de farine de qualité supérieure au cameroun. Nous nous engageons à fournir des produits répondant aux standards internationaux.') }}
                </p>
                <div class="social-links mt-3">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

            <!-- Liens rapides -->
            <div class="col-lg-2 col-md-3 col-6">
                <h5>{{ __('Liens rapides') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Accueil') }}</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('À Propos') }}</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Produits') }}</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Services') }}</a></li>
                    <li class="mb-2"><a href="{{ route('careers.index') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Carrières') }}</a></li>
                    <li class="mb-2"><a href="{{ route('admin.login') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Administration') }}</a></li>
                    <li class="mb-2"><a href="{{ route('employee.login') }}"><i class="bi bi-chevron-right me-1" style="color:var(--secondary);font-size:.7rem;"></i>{{ __('Espace Employés') }}</a></li>
                </ul>
            </div>

            <!-- Produits -->
            <div class="col-lg-2 col-md-3 col-6">
                <h5>{{ __('Nos Produits') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('products.index') }}">{{ __('Farine Premium 1kg') }}</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}">{{ __('Farine Premium 50kg') }}</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}">{{ __('Farine Boulangerie') }}</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}">{{ __('Semoule de Blé') }}</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}">{{ __('Son de Blé') }}</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-4 col-md-6">
                <h5>{{ __('Contact') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill me-2 mt-1" style="color:var(--secondary);"></i>
                        <span>Avenue Industrielle, Zone de Essengue,<br>Douala, {{ app()->getLocale() === 'en' ? 'CAMEROON' : 'CAMEROUN' }}</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill me-2" style="color:var(--secondary);"></i>
                        <a href="tel:+237620731930">+237 620 731 930</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill me-2" style="color:var(--secondary);"></i>
                        <a href="mailto:info@mimosaflour.com">info@mimosaflour.com</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock-fill me-2" style="color:var(--secondary);"></i>
                        {{ __('Lun – Ven : 7h00 – 17h00') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            © {{ date('Y') }} <strong style="color:var(--secondary);">Mimosa</strong>.
            {{ __('Tous droits réservés.') }} — MIMOSA, {{ app()->getLocale() === 'en' ? 'CAMEROON' : 'CAMEROUN' }}
        </div>
    </div>
</footer>

{{-- ===== MODAL PANIER ===== --}}
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border:none; border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:var(--primary); color:#fff; border:none; padding:1.2rem 1.5rem;">
                <h6 class="modal-title" id="cartModalLabel">
                    <i class="bi bi-cart-plus me-2" style="color:var(--secondary);"></i>
                    {{ __('Ajouter au panier') }}
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('cart.add') }}" id="cartModalForm">
                @csrf
                <input type="hidden" name="product_id" id="cartProductId">
                <div class="modal-body" style="padding:1.5rem;">
                    <div id="cartProductName" class="fw-bold mb-4" style="color:var(--primary); font-family:'Montserrat',sans-serif; font-size:1rem;"></div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color:#475569;">{{ __('Type de commande') }}</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeDetail" value="detail" checked>
                                <label class="form-check-label" for="typeDetail">
                                    <strong class="small">{{ __('Détail') }}</strong>
                                    <div id="detailPrice" class="text-muted" style="font-size:.72rem;"></div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeGros" value="gros">
                                <label class="form-check-label" for="typeGros">
                                    <strong class="small">{{ __('Gros') }}</strong>
                                    <div class="text-muted" style="font-size:.72rem;">{{ __('min. 100 unités — sur devis') }}</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label small fw-bold" style="color:#475569;" for="cartQty">{{ __('Quantité') }}</label>
                        <input type="number" name="quantity" id="cartQty" class="form-control"
                               value="1" min="1" required
                               style="border-color:#e2e8f0;">
                        <div class="form-text small" id="cartQtyHint"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0" style="padding:0 1.5rem 1.5rem;">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-cart-check me-2"></i>{{ __('Ajouter au panier') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<!-- Bootstrap JS (local) -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- AOS (local) -->
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 80 });

    // Auto-dismiss flash messages
    setTimeout(() => {
        document.querySelectorAll('.alert-flash').forEach(el => {
            const bs = bootstrap.Alert.getOrCreateInstance(el);
            bs.close();
        });
    }, 5000);

    // ===== CART MODAL =====
    function openCartModal(productId, productName, price) {
        document.getElementById('cartProductId').value = productId;
        document.getElementById('cartProductName').textContent = productName;

        const priceEl = document.getElementById('detailPrice');
        priceEl.textContent = price ? new Intl.NumberFormat('fr-FR').format(price) + ' FC/u' : '';

        // Reset form state
        document.getElementById('typeDetail').checked = true;
        const qtyInput = document.getElementById('cartQty');
        qtyInput.value = 1;
        qtyInput.min = 1;
        document.getElementById('cartQtyHint').textContent = '';
        document.getElementById('cartQtyHint').className = 'form-text small';

        new bootstrap.Modal(document.getElementById('cartModal')).show();
    }

    // Update min quantity when order type changes
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[name="type"]').forEach(function (el) {
            el.addEventListener('change', function () {
                const qtyInput = document.getElementById('cartQty');
                const hint = document.getElementById('cartQtyHint');
                if (this.value === 'gros') {
                    qtyInput.min = 100;
                    if (parseInt(qtyInput.value) < 100) qtyInput.value = 100;
                    hint.textContent = 'Minimum 100 unités pour les commandes en gros.';
                    hint.className = 'form-text small text-warning';
                } else {
                    qtyInput.min = 1;
                    hint.textContent = '';
                    hint.className = 'form-text small';
                }
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
