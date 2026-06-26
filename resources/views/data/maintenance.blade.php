<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance en cours</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--primary:#1a3a5c;--gold:#c8a84b;--bg:#f8f5ef;--text:#1a2639;--muted:#64748b}
        body{background:var(--bg);font-family:'Segoe UI',Arial,sans-serif;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;position:relative;overflow:hidden}
        /* Background pattern */
        body::before{content:'';position:fixed;inset:0;background:linear-gradient(135deg,rgba(26,58,92,.04) 25%,transparent 25%) -20px 0,linear-gradient(225deg,rgba(26,58,92,.04) 25%,transparent 25%) -20px 0,linear-gradient(315deg,rgba(26,58,92,.04) 25%,transparent 25%),linear-gradient(45deg,rgba(26,58,92,.04) 25%,transparent 25%);background-size:40px 40px;pointer-events:none;z-index:0}
        .wrap{position:relative;z-index:1;text-align:center;max-width:600px;width:100%}
        /* Gear icon */
        .gear-wrap{margin-bottom:2rem}
        .gear-outer{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;margin-bottom:.5rem}
        .gear{font-size:2.8rem;animation:spin 6s linear infinite;display:inline-block;color:var(--primary)}
        .gear.small{font-size:1.6rem;animation-direction:reverse;animation-duration:4s;color:var(--gold)}
        @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        /* Card */
        .card{background:#fff;border-radius:12px;padding:3rem 2.5rem;box-shadow:0 10px 50px rgba(26,58,92,.1);border-top:5px solid var(--gold)}
        .badge{display:inline-block;background:rgba(200,168,75,.12);color:var(--gold);font-size:.72rem;font-weight:700;padding:.3rem .9rem;border-radius:20px;letter-spacing:1.5px;text-transform:uppercase;border:1px solid rgba(200,168,75,.3);margin-bottom:1.2rem}
        .card h1{font-size:1.8rem;color:var(--primary);font-weight:800;margin-bottom:.7rem}
        .card p{color:var(--muted);font-size:.92rem;line-height:1.75;margin-bottom:1.5rem}
        /* Progress */
        .progress-wrap{margin-bottom:2rem}
        .progress-label{display:flex;justify-content:space-between;font-size:.75rem;color:var(--muted);margin-bottom:.5rem}
        .progress-bar{height:6px;background:#e2e8f0;border-radius:10px;overflow:hidden}
        .progress-fill{height:100%;background:linear-gradient(90deg,var(--primary),var(--gold));border-radius:10px;animation:fill 3s ease-in-out infinite alternate}
        @keyframes fill{from{width:35%}to{width:85%}}
        /* Info grid */
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem}
        .info-item{background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:.9rem}
        .info-item .lbl{font-size:.68rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;font-weight:700;margin-bottom:.3rem}
        .info-item .val{font-size:.92rem;font-weight:700;color:var(--primary)}
        /* Countdown */
        .countdown{display:flex;justify-content:center;gap:1.2rem;margin:1.5rem 0}
        .cd-unit{text-align:center}
        .cd-num{font-size:2rem;font-weight:800;color:var(--primary);font-family:'Courier New',monospace;min-width:52px;display:block;background:#f1f5f9;border-radius:6px;padding:.2rem .6rem;line-height:1.3}
        .cd-lbl{font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:.3rem;display:block}
        .cd-sep{font-size:1.8rem;font-weight:700;color:var(--gold);padding-top:.1rem;animation:blink .8s step-end infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
        /* Subscribe */
        .notify{background:#f0f7ff;border:1px solid #bee3f8;border-radius:8px;padding:1.2rem;font-size:.82rem;color:var(--muted);margin-top:1rem}
        .notify strong{display:block;color:var(--primary);margin-bottom:.3rem}
        @media(max-width:500px){.info-grid{grid-template-columns:1fr}.countdown{gap:.7rem}.cd-num{font-size:1.5rem}}
    </style>
</head>
<body>
<div class="wrap">
    <div class="gear-wrap">
        <div class="gear-outer">
            <span class="gear">⚙</span>
            <span class="gear small">⚙</span>
        </div>
    </div>

    <div class="card">
        <div class="badge">🔧 &nbsp; Maintenance planifiée</div>
        <h1>Nous serons bientôt de retour</h1>
        <p>Notre équipe technique effectue actuellement des opérations de maintenance
           pour améliorer les performances et la stabilité du service.
           Nous nous excusons pour la gêne occasionnée.</p>

        <div class="progress-wrap">
            <div class="progress-label">
                <span>Avancement</span>
                <span id="pct">—</span>
            </div>
            <div class="progress-bar"><div class="progress-fill" id="prog"></div></div>
        </div>

        <div class="countdown">
            <div class="cd-unit"><span class="cd-num" id="cd-h">02</span><span class="cd-lbl">Heures</span></div>
            <span class="cd-sep">:</span>
            <div class="cd-unit"><span class="cd-num" id="cd-m">30</span><span class="cd-lbl">Minutes</span></div>
            <span class="cd-sep">:</span>
            <div class="cd-unit"><span class="cd-num" id="cd-s">00</span><span class="cd-lbl">Secondes</span></div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="lbl">Début</div>
                <div class="val">{{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="lbl">Fin estimée</div>
                <div class="val">{{ now()->addHours(2)->addMinutes(30)->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="lbl">Type</div>
                <div class="val">Mise à jour système</div>
            </div>
            <div class="info-item">
                <div class="lbl">Référence</div>
                <div class="val">MNT-{{ now()->format('Ymd') }}-{{ rand(10,99) }}</div>
            </div>
        </div>

        <div class="notify">
            <strong>Besoin d'une assistance urgente ?</strong>
            Contactez notre support : <strong>support@mimosaflour.com</strong>
            ou appelez le <strong>+237 620 731 930</strong>
        </div>
    </div>
</div>

<script>
// Countdown: 2h30 depuis le chargement
let total = 2 * 3600 + 30 * 60;
function pad(n){return String(n).padStart(2,'0')}
function tick(){
    if(total<=0){document.getElementById('cd-h').textContent='00';document.getElementById('cd-m').textContent='00';document.getElementById('cd-s').textContent='00';return}
    const h=Math.floor(total/3600),m=Math.floor((total%3600)/60),s=total%60;
    document.getElementById('cd-h').textContent=pad(h);
    document.getElementById('cd-m').textContent=pad(m);
    document.getElementById('cd-s').textContent=pad(s);
    total--;
}
tick(); setInterval(tick,1000);
// Progress animation label
const prog=document.getElementById('prog'),pct=document.getElementById('pct');
setInterval(()=>{const w=parseFloat(getComputedStyle(prog).width)/parseFloat(getComputedStyle(prog.parentNode).width)*100;pct.textContent=Math.round(w)+'%'},200);
</script>
</body>
</html>
