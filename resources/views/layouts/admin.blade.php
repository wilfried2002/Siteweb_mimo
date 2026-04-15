<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title', 'Dashboard') — Mimosa Flour</title>

    <!-- Bootstrap 5 (local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Google Fonts (local) -->
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">

    <style>
        :root {
            --admin-primary:   #1a3a5c;
            --admin-secondary: #c8a84b;
            --admin-sidebar:   #0d1f33;
            --admin-hover:     rgba(200,168,75,.12);
            --admin-active:    rgba(200,168,75,.18);
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--admin-sidebar);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        #sidebar .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .sidebar-header img { height: 50px; }
        #sidebar .sidebar-header .site-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--admin-secondary);
            font-size: 1.1rem;
        }
        #sidebar .sidebar-header small { color: rgba(255,255,255,.45); font-size:.72rem; }

        #sidebar .nav-section-title {
            color: rgba(255,255,255,.35);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 1.5rem 1.5rem .4rem;
        }

        #sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.72);
            padding: .7rem 1.5rem;
            border-radius: 0;
            font-size: .88rem;
            display: flex;
            align-items: center;
            gap: .8rem;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        #sidebar .nav-item .nav-link i { font-size: 1rem; width: 20px; }
        #sidebar .nav-item .nav-link:hover {
            background: var(--admin-hover);
            color: var(--admin-secondary);
            border-left-color: var(--admin-secondary);
        }
        #sidebar .nav-item .nav-link.active {
            background: var(--admin-active);
            color: var(--admin-secondary);
            border-left-color: var(--admin-secondary);
            font-weight: 600;
        }

        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1.2rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        /* ===== MAIN CONTENT ===== */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left .3s;
        }

        /* ===== TOPBAR ===== */
        .admin-topbar {
            background: #fff;
            padding: .9rem 1.8rem;
            box-shadow: 0 1px 10px rgba(0,0,0,.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-topbar .page-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--admin-primary);
            font-size: 1.1rem;
        }

        /* ===== CARDS STAT ===== */
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,.06);
            border-left: 4px solid var(--admin-secondary);
            transition: transform .2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-card .icon {
            width: 50px; height: 50px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        /* ===== TABLES ===== */
        .table-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .table-card .table-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-card .table-header h5 {
            margin: 0;
            color: var(--admin-primary);
            font-size: 1rem;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e8ecf0;
            padding: .9rem 1rem;
            font-family: 'Montserrat', sans-serif;
        }
        .table tbody td { padding: .9rem 1rem; vertical-align: middle; }
        .table tbody tr:hover { background: #fafbfd; }

        /* ===== FORMS ===== */
        .form-card {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,.06);
        }
        .form-label { font-weight: 600; font-size: .85rem; color: #475569; }
        .form-control:focus, .form-select:focus {
            border-color: var(--admin-secondary);
            box-shadow: 0 0 0 .2rem rgba(200,168,75,.2);
        }

        /* ===== BTN ADMIN ===== */
        .btn-admin {
            background: var(--admin-secondary);
            color: var(--admin-sidebar);
            border: none;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: .85rem;
            padding: .5rem 1.2rem;
            border-radius: 6px;
        }
        .btn-admin:hover { background: #b8962f; color: #fff; }

        /* Badges statut */
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-reviewed { background: #dbeafe; color: #1e40af; }
        .badge-accepted { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar { transform: translateX(-260px); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-header d-flex align-items-center gap-3">
        <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Logo" class="rounded">
        <div>
            <div class="site-name">Mimosa Flour</div>
            <small>Administration</small>
        </div>
    </div>

    <ul class="nav flex-column mt-2">
        <li class="nav-section-title">Principal</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
        </li>

        <li class="nav-section-title">Catalogue</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               href="{{ route('admin.products.index') }}">
                <i class="bi bi-bag"></i> Produits
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}"
               href="{{ route('admin.sliders.index') }}">
                <i class="bi bi-images"></i> Sliders
            </a>
        </li>

        <li class="nav-section-title">Carrières</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}"
               href="{{ route('admin.jobs.index') }}">
                <i class="bi bi-briefcase"></i> Offres d'emploi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}"
               href="{{ route('admin.applications.index') }}">
                <i class="bi bi-people"></i> Candidatures
                @php $pending = \App\Models\JobApplication::where('status','pending')->count(); @endphp
                @if($pending > 0)
                    <span class="badge rounded-pill ms-auto"
                          style="background:var(--admin-secondary); color:#000; font-size:.65rem;">
                        {{ $pending }}
                    </span>
                @endif
            </a>
        </li>

        <li class="nav-section-title">Commandes</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
               href="{{ route('admin.orders.index') }}">
                <i class="bi bi-bag-check"></i> Commandes
                @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingOrders > 0)
                    <span class="badge rounded-pill ms-auto"
                          style="background:var(--admin-secondary); color:#000; font-size:.65rem;">
                        {{ $pendingOrders }}
                    </span>
                @endif
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:38px; height:38px; background:var(--admin-secondary); border-radius:50%;
                        display:flex; align-items:center; justify-content:center; font-weight:700; color:#000;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div style="color:#fff; font-size:.85rem; font-weight:600;">{{ auth()->user()->name }}</div>
                <div style="color:rgba(255,255,255,.4); font-size:.72rem;">Administrateur</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.08); color:rgba(255,255,255,.7); font-size:.82rem;">
                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
            </button>
        </form>
    </div>
</nav>

<!-- Main Content -->
<div id="main-content">
    <!-- Topbar -->
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none" id="sidebarToggle"
                    style="border:none; background:transparent; font-size:1.3rem; color:var(--admin-primary);">
                <i class="bi bi-list"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-eye me-1"></i> Voir le site
            </a>
        </div>
    </div>

    <!-- Content -->
    <div style="padding: 2rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS (local) -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
