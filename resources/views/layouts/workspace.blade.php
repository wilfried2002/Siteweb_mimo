<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace') — Mimosa Flour</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">
    <style>
        :root {
            --ws-primary:   #1a3a5c;
            --ws-secondary: #c8a84b;
            --ws-sidebar:   #0d1f33;
        }
        body { font-family: 'Open Sans', sans-serif; background: #f0f4f8; min-height: 100vh; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Montserrat', sans-serif; }

        #ws-sidebar {
            width: 240px; min-height: 100vh;
            background: var(--ws-sidebar);
            position: fixed; top: 0; left: 0;
            z-index: 1000; transition: all .3s;
            display: flex; flex-direction: column;
        }
        #ws-sidebar .sidebar-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #ws-sidebar .sidebar-header img { height: 42px; }
        #ws-sidebar .sidebar-header .site-name {
            font-family: 'Montserrat', sans-serif; font-weight: 700;
            color: var(--ws-secondary); font-size: 1rem;
        }
        #ws-sidebar .sidebar-header small { color: rgba(255,255,255,.4); font-size: .7rem; }
        #ws-sidebar .nav-section {
            color: rgba(255,255,255,.3); font-size: .65rem; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            padding: 1.2rem 1.5rem .35rem;
        }
        #ws-sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.7); padding: .65rem 1.5rem;
            font-size: .85rem; display: flex; align-items: center;
            gap: .75rem; transition: all .2s;
            border-left: 3px solid transparent;
        }
        #ws-sidebar .nav-item .nav-link i { font-size: .95rem; width: 18px; }
        #ws-sidebar .nav-item .nav-link:hover,
        #ws-sidebar .nav-item .nav-link.active {
            background: rgba(200,168,75,.15);
            color: var(--ws-secondary);
            border-left-color: var(--ws-secondary);
        }
        #ws-sidebar .nav-item .nav-link.active { font-weight: 600; }
        #ws-sidebar .sidebar-footer {
            margin-top: auto; padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        #ws-main { margin-left: 240px; min-height: 100vh; }
        .ws-topbar {
            background: #fff; padding: .8rem 1.6rem;
            box-shadow: 0 1px 8px rgba(0,0,0,.07);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .ws-topbar .page-title {
            font-family: 'Montserrat', sans-serif; font-weight: 700;
            color: var(--ws-primary); font-size: 1.05rem;
        }

        .stat-card {
            background: #fff; border-radius: 10px; padding: 1.4rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            border-left: 4px solid var(--ws-secondary);
        }
        .table-card {
            background: #fff; border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06); overflow: hidden;
        }
        .table-card .tc-header {
            padding: 1.1rem 1.4rem; border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .table-card .tc-header h5 { margin: 0; color: var(--ws-primary); font-size: .95rem; }
        .table thead th {
            background: #f8fafc; color: #64748b; font-size: .73rem;
            text-transform: uppercase; letter-spacing: 1px;
            border-bottom: 2px solid #e8ecf0; padding: .85rem 1rem;
            font-family: 'Montserrat', sans-serif;
        }
        .table tbody td { padding: .85rem 1rem; vertical-align: middle; }
        .table tbody tr:hover { background: #fafbfd; }

        .form-card { background: #fff; border-radius: 10px; padding: 1.8rem; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .form-label { font-weight: 600; font-size: .83rem; color: #475569; }
        .form-control:focus, .form-select:focus {
            border-color: var(--ws-secondary);
            box-shadow: 0 0 0 .2rem rgba(200,168,75,.2);
        }
        .btn-ws {
            background: var(--ws-secondary); color: var(--ws-sidebar);
            border: none; font-family: 'Montserrat', sans-serif;
            font-weight: 700; font-size: .83rem;
            padding: .5rem 1.1rem; border-radius: 6px;
        }
        .btn-ws:hover { background: #b8962f; color: #fff; }

        @media (max-width: 992px) {
            #ws-sidebar { transform: translateX(-240px); }
            #ws-sidebar.show { transform: translateX(0); }
            #ws-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav id="ws-sidebar">
    <div class="sidebar-header d-flex align-items-center gap-2">
        <img src="{{ asset('images/Logo Mimosa2.jpg') }}" alt="Logo" class="rounded">
        <div>
            <div class="site-name">Mimosa</div>
            <small>{{ auth()->user()->role?->label ?? 'Employé' }}</small>
        </div>
    </div>

    @yield('sidebar-nav')

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width:34px;height:34px;background:var(--ws-secondary);border-radius:50%;
                        display:flex;align-items:center;justify-content:center;font-weight:700;color:#000;font-size:.85rem;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div style="color:#fff;font-size:.82rem;font-weight:600;">{{ auth()->user()->name }}</div>
                <div style="color:rgba(255,255,255,.38);font-size:.68rem;">{{ auth()->user()->role?->label }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('employee.logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.07);color:rgba(255,255,255,.65);font-size:.8rem;">
                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
            </button>
        </form>
    </div>
</nav>

<div id="ws-main">
    <div class="ws-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none" id="sidebarToggle"
                    style="border:none;background:transparent;font-size:1.2rem;color:var(--ws-primary);">
                <i class="bi bi-list"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Tableau de bord')</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-eye me-1"></i>Site
            </a>
        </div>
    </div>

    <div style="padding: 1.8rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('ws-sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
