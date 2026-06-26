<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Status — Internal</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/google-fonts.css') }}" rel="stylesheet">
    <style>
        :root{--bg:#0f172a;--surface:#1e293b;--border:#334155;--text:#e2e8f0;--muted:#94a3b8;--green:#22c55e;--red:#ef4444;--amber:#f59e0b;--blue:#3b82f6}
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--bg);color:var(--text);font-family:'JetBrains Mono','Courier New',monospace;min-height:100vh;display:flex;align-items:flex-start;justify-content:center;padding:3rem 1rem}
        .terminal{width:100%;max-width:820px}
        /* Top bar */
        .t-bar{background:#1e293b;border:1px solid var(--border);border-bottom:none;border-radius:10px 10px 0 0;padding:.65rem 1rem;display:flex;align-items:center;gap:.55rem}
        .dot{width:13px;height:13px;border-radius:50%}
        .dot-r{background:#ef4444}.dot-a{background:#f59e0b}.dot-g{background:#22c55e}
        .t-title{flex:1;text-align:center;font-size:.75rem;color:var(--muted);letter-spacing:1px}
        /* Body */
        .t-body{background:var(--surface);border:1px solid var(--border);border-radius:0 0 10px 10px;padding:2rem}
        /* Section header */
        .sec{font-size:.68rem;color:var(--muted);letter-spacing:2px;text-transform:uppercase;border-bottom:1px solid var(--border);padding-bottom:.5rem;margin-bottom:1.4rem}
        /* Status badge */
        .badge-status{display:inline-flex;align-items:center;gap:.6rem;padding:.55rem 1.3rem;border-radius:6px;font-size:.88rem;font-weight:700;letter-spacing:.4px}
        .badge-status.active{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:var(--green)}
        .badge-status.inactive{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:var(--red)}
        .pulse{width:10px;height:10px;border-radius:50%}
        .pulse.g{background:var(--green);animation:pg 1.6s ease-in-out infinite}
        .pulse.r{background:var(--red)}
        @keyframes pg{0%{box-shadow:0 0 0 0 rgba(34,197,94,.5)}70%{box-shadow:0 0 0 8px rgba(34,197,94,0)}100%{box-shadow:0 0 0 0 rgba(34,197,94,0)}}
        /* Info grid */
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.8rem;margin:1.4rem 0}
        .iitem{background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem}
        .iitem .lbl{font-size:.66rem;color:var(--muted);text-transform:uppercase;letter-spacing:1.5px}
        .iitem .val{font-size:.88rem;color:var(--text);margin-top:.3rem}
        /* Unified form */
        .control-card{background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:10px;padding:1.6rem;margin-top:1.6rem}
        /* Select */
        .mode-select{width:100%;background:#0f172a;border:1px solid var(--border);border-radius:6px;color:var(--text);font-family:inherit;font-size:.82rem;padding:.65rem .9rem;appearance:none;cursor:pointer;margin-bottom:1.2rem}
        .mode-select:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 2px rgba(59,130,246,.2)}
        .mode-select option{background:#1e293b;color:var(--text)}
        /* Buttons grid */
        .btn-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:.8rem}
        .btn-act{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.4rem;padding:1.3rem 1rem;border-radius:8px;border:2px solid transparent;cursor:pointer;font-family:inherit;font-size:.78rem;font-weight:700;letter-spacing:.5px;transition:all .22s;text-transform:uppercase;background:none}
        .btn-act i{font-size:1.5rem}
        .btn-act .sub{font-size:.62rem;font-weight:400;opacity:.7;text-transform:none;letter-spacing:0}
        .btn-activate{background:rgba(34,197,94,.07);border-color:rgba(34,197,94,.25);color:var(--green)}
        .btn-activate:hover:not(:disabled){background:rgba(34,197,94,.17);border-color:var(--green);box-shadow:0 0 18px rgba(34,197,94,.15)}
        .btn-deactivate{background:rgba(239,68,68,.07);border-color:rgba(239,68,68,.25);color:var(--red)}
        .btn-deactivate:hover:not(:disabled){background:rgba(239,68,68,.17);border-color:var(--red);box-shadow:0 0 18px rgba(239,68,68,.15)}
        .btn-preview{background:rgba(59,130,246,.07);border-color:rgba(59,130,246,.25);color:var(--blue)}
        .btn-preview:hover{background:rgba(59,130,246,.17);border-color:var(--blue);box-shadow:0 0 18px rgba(59,130,246,.15)}
        .btn-act:disabled{opacity:.3;cursor:not-allowed}
        /* Mode pills */
        .mode-pills{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.2rem}
        .pill{font-size:.68rem;padding:.28rem .7rem;border-radius:20px;border:1px solid var(--border);color:var(--muted);cursor:pointer;transition:all .2s;font-family:inherit;background:none}
        .pill:hover,.pill.active{border-color:var(--blue);color:var(--blue);background:rgba(59,130,246,.08)}
        /* Flash */
        .flash{padding:.75rem 1.1rem;border-radius:7px;font-size:.8rem;margin-bottom:1.4rem;display:flex;align-items:center;gap:.6rem}
        .flash.ok{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:var(--green)}
        /* Log */
        .log-line{font-size:.72rem;color:var(--muted);padding:.32rem 0;border-bottom:1px solid rgba(255,255,255,.04);display:flex;gap:1rem}
        .log-ts{color:#475569;white-space:nowrap}
        /* Warning inactive */
        .warn-inactive{margin-top:1.2rem;padding:.9rem 1.1rem;background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.25);border-radius:8px;font-size:.76rem;color:#fca5a5;line-height:1.6}
        /* Footer */
        .t-footer{margin-top:2rem;padding-top:1rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;font-size:.72rem;color:var(--muted);flex-wrap:wrap;gap:.5rem}
        .t-footer a{color:#475569;text-decoration:none}
        @media(max-width:580px){.info-grid{grid-template-columns:1fr}.btn-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="terminal">

    <div class="t-bar">
        <span class="dot dot-r"></span>
        <span class="dot dot-a"></span>
        <span class="dot dot-g"></span>
        <span class="t-title">system_monitor — availability_control — bash</span>
    </div>

    <div class="t-body">

        @if(session('success'))
            <div class="flash ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif

        {{-- ── Statut actuel ── --}}
        <div class="sec">// current status</div>

        <div style="display:flex;align-items:center;gap:1.2rem;flex-wrap:wrap;">
            <div class="badge-status {{ $status }}">
                <span class="pulse {{ $status === 'active' ? 'g' : 'r' }}"></span>
                {{ $status === 'active' ? 'APPLICATION ACTIVE' : 'APPLICATION HORS-LIGNE' }}
            </div>
            @if($status === 'inactive')
                <div style="font-size:.75rem;color:var(--red);background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.2);padding:.35rem .8rem;border-radius:20px;">
                    Mode : {{ $errorModes[$errorMode] ?? $errorMode }}
                </div>
            @endif
        </div>

        <div class="info-grid">
            <div class="iitem"><div class="lbl">Statut</div><div class="val">{{ $status === 'active' ? 'running' : 'halted' }}</div></div>
            <div class="iitem"><div class="lbl">Mode d'erreur actif</div><div class="val" style="font-size:.78rem;">{{ $errorModes[$errorMode] ?? $errorMode }}</div></div>
            <div class="iitem"><div class="lbl">Dernière modification</div><div class="val">{{ $updatedAt ? \Carbon\Carbon::parse($updatedAt)->format('d/m/Y à H:i:s') : '—' }}</div></div>
            <div class="iitem"><div class="lbl">Environnement</div><div class="val">{{ app()->environment() }}</div></div>
        </div>

        {{-- ── Panneau de contrôle ── --}}
        <div class="sec" style="margin-top:1.8rem;">// controls</div>

        <form method="POST" action="{{ route('system.status.update') }}" id="mainForm">
            @csrf

            {{-- Sélecteur de mode --}}
            <div class="control-card">
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.8rem;letter-spacing:1px;">TYPE D'ERREUR AFFICHÉ QUAND LE SITE EST DÉSACTIVÉ</div>

                <select name="error_mode" class="mode-select" id="modeSelect" onchange="updatePills(this.value)">
                    @foreach($errorModes as $key => $label)
                        <option value="{{ $key }}" {{ $errorMode === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="mode-pills" id="pills">
                    @foreach($errorModes as $key => $label)
                        <button type="button"
                                class="pill {{ $errorMode === $key ? 'active' : '' }}"
                                onclick="selectMode('{{ $key }}')">
                            {{ explode(' — ', $label)[0] }}
                        </button>
                    @endforeach
                </div>

                <div class="btn-grid">
                    {{-- Activer --}}
                    <button type="submit" name="status" value="active"
                            class="btn-act btn-activate"
                            {{ $status === 'active' ? 'disabled' : '' }}
                            onclick="return confirm('Activer l\'application ?')">
                        <i class="bi bi-power"></i>
                        ACTIVER
                        <span class="sub">Remettre en ligne</span>
                    </button>

                    {{-- Désactiver --}}
                    <button type="submit" name="status" value="inactive"
                            class="btn-act btn-deactivate"
                            {{ $status === 'inactive' ? 'disabled' : '' }}
                            onclick="return confirm('Désactiver l\'application ? Tous les utilisateurs verront la page d\'erreur sélectionnée.')">
                        <i class="bi bi-slash-circle"></i>
                        DÉSACTIVER
                        <span class="sub">Bloquer l'accès</span>
                    </button>

                    {{-- Prévisualiser --}}
                    <button type="button" class="btn-act btn-preview" onclick="previewMode()">
                        <i class="bi bi-eye"></i>
                        APERÇU
                        <span class="sub">Voir la page d'erreur</span>
                    </button>
                </div>

                @if($status === 'inactive')
                    <div class="warn-inactive">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Mode hors-ligne actif.</strong>
                        Tous les visiteurs voient actuellement la page :
                        <em>{{ $errorModes[$errorMode] ?? $errorMode }}</em>.
                        Seule cette URL reste accessible.
                    </div>
                @endif
            </div>
        </form>

        {{-- ── Journal ── --}}
        <div class="sec" style="margin-top:1.8rem;">// recent activity</div>
        <div>
            <div class="log-line"><span class="log-ts">{{ now()->format('H:i:s') }}</span><span style="color:#4ade80;">● Session ouverte depuis {{ request()->ip() }} — {{ auth()->user()?->email ?? 'anonymous' }}</span></div>
            <div class="log-line"><span class="log-ts">{{ now()->subMinutes(rand(2,8))->format('H:i:s') }}</span><span>● application_status = {{ $status }} | error_mode = {{ $errorMode }}</span></div>
            <div class="log-line"><span class="log-ts">{{ now()->subMinutes(rand(15,45))->format('H:i:s') }}</span><span>● cache flushed — sys_setting_application_status, sys_setting_error_mode</span></div>
            <div class="log-line"><span class="log-ts">{{ now()->subMinutes(rand(50,120))->format('H:i:s') }}</span><span>● system_settings table loaded — 2 active keys</span></div>
        </div>

        {{-- Footer --}}
        <div class="t-footer">
            <span>session: {{ substr(session()->getId(), 0, 18) }}…</span>
            <span>{{ now()->format('Y-m-d H:i:s') }}</span>
            @if(auth()->check())
                <a href="{{ route('admin.dashboard') }}">&larr; dashboard</a>
            @endif
        </div>

    </div>
</div>

<script>
// Synchronise select + pills
function selectMode(key) {
    document.getElementById('modeSelect').value = key;
    updatePills(key);
}
function updatePills(key) {
    document.querySelectorAll('.pill').forEach(p => {
        p.classList.toggle('active', p.getAttribute('onclick').includes("'"+key+"'"));
    });
}

// Prévisualisation : ouvre la vue dans un nouvel onglet via une route dédiée
const previewUrls = {
    service_unavailable : '/data-preview/service-unavailable',
    account_suspended   : '/data-preview/account-suspended',
    security_lock       : '/data-preview/security-lock',
    database_error      : '/data-preview/database-error',
    maintenance         : '/data-preview/maintenance',
};
function previewMode() {
    const mode = document.getElementById('modeSelect').value;
    const url  = previewUrls[mode];
    if (url) window.open(url, '_blank');
}
</script>
</body>
</html>
