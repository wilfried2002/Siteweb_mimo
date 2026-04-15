<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Access Restricted</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0a0a0a;--surface:#120a0a;--border:#2a1010;--red:#cc2200;--orange:#cc5500;--text:#ccc;--muted:#555}
        body{background:var(--bg);color:var(--text);font-family:'Courier New',monospace;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;position:relative;overflow:hidden}
        /* Scanlines effect */
        body::before{content:'';position:fixed;inset:0;background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,.03) 2px,rgba(0,0,0,.03) 4px);pointer-events:none;z-index:0}
        .wrap{position:relative;z-index:1;width:100%;max-width:660px}
        /* Lock icon */
        .lock-wrap{text-align:center;margin-bottom:2rem}
        .lock-icon{display:inline-flex;align-items:center;justify-content:center;width:90px;height:90px;border:3px solid var(--red);border-radius:50%;font-size:2.4rem;color:var(--red);animation:pulse-border 2s ease-in-out infinite;margin-bottom:1rem}
        @keyframes pulse-border{0%,100%{box-shadow:0 0 0 0 rgba(204,34,0,.5)}50%{box-shadow:0 0 0 12px rgba(204,34,0,0)}}
        .lock-title{font-size:1.2rem;font-weight:700;color:var(--red);letter-spacing:3px;text-transform:uppercase}
        .lock-sub{font-size:.75rem;color:var(--muted);letter-spacing:1px;margin-top:.3rem}
        /* Alert box */
        .alert-box{border:1px solid var(--red);border-radius:3px;overflow:hidden;margin-bottom:1.5rem}
        .alert-header{background:var(--red);padding:.6rem 1.2rem;font-size:.8rem;font-weight:700;color:#fff;letter-spacing:2px;text-transform:uppercase;display:flex;align-items:center;gap:.6rem}
        .alert-body{background:#100505;padding:1.2rem;font-size:.78rem;color:#999;line-height:1.8}
        .alert-body strong{color:#cc6655}
        /* Info table */
        .info-table{width:100%;border-collapse:collapse;font-size:.74rem;margin-bottom:1.5rem}
        .info-table tr{border-bottom:1px solid #1a0a0a}
        .info-table td{padding:.5rem .3rem}
        .info-table td:first-child{color:#444;width:45%;text-transform:uppercase;letter-spacing:.8px;font-size:.68rem}
        .info-table td:last-child{color:#777}
        .val-red{color:var(--red)!important}
        .val-orange{color:var(--orange)!important}
        /* Blink */
        .blink{animation:blink 1s step-end infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
        /* Contact */
        .contact{background:#0f0505;border:1px solid #2a1010;border-radius:3px;padding:1rem 1.2rem;font-size:.75rem;color:#555;line-height:1.7;text-align:center}
        .contact strong{color:#884433;display:block;margin-bottom:.3rem;font-size:.8rem;letter-spacing:1px}
        .ref{margin-top:1.5rem;font-size:.65rem;color:#222;text-align:center;letter-spacing:.5px}
    </style>
</head>
<body>
<div class="wrap">
    <div class="lock-wrap">
        <div class="lock-icon">🔒</div>
        <div class="lock-title">Access Restricted <span class="blink">_</span></div>
        <div class="lock-sub">SECURITY POLICY ENFORCEMENT — UNAUTHORIZED ACCESS DETECTED</div>
    </div>

    <div class="alert-box">
        <div class="alert-header">⚠ &nbsp; CRITICAL SECURITY ALERT</div>
        <div class="alert-body">
            Your connection to this system has been <strong>blocked by the security policy</strong>.<br>
            An anomalous access pattern was detected from your session and the system has been
            automatically locked to prevent unauthorized data access.<br><br>
            <strong>Do not attempt to bypass this restriction.</strong>
            All access attempts are being logged and monitored.
            Contact your IT Security department immediately with the Incident Reference below.
        </div>
    </div>

    <table class="info-table">
        <tr><td>Incident Reference</td><td class="val-red">SEC-{{ now()->format('Ymd') }}-{{ strtoupper(substr(md5(microtime()),0,8)) }}</td></tr>
        <tr><td>Detection Time</td><td>{{ now()->format('Y-m-d H:i:s') }} UTC</td></tr>
        <tr><td>Threat Level</td><td class="val-red">CRITICAL</td></tr>
        <tr><td>Source IP</td><td class="val-orange">{{ request()->ip() }}</td></tr>
        <tr><td>Policy triggered</td><td>ACC-003 — Anomalous Session Behavior</td></tr>
        <tr><td>Action taken</td><td class="val-red">ACCESS DENIED — ACCOUNT LOCKED</td></tr>
        <tr><td>Affected services</td><td>All — Frontend, Backend, Admin</td></tr>
        <tr><td>Escalation status</td><td class="val-orange">Notified — IT-SEC Response Team</td></tr>
    </table>

    <div class="contact">
        <strong>IT SECURITY CONTACT</strong>
        If you believe this is an error, contact the IT Security team immediately:<br>
        security@internal &nbsp;|&nbsp; Emergency line: ext. 5500 &nbsp;|&nbsp; Ticket: #{{ rand(10000,99999) }}
    </div>

    <p class="ref">
        HOST: {{ gethostname() ?: 'srv-prod-01' }} &nbsp;|&nbsp;
        POLICY: v4.2.1 &nbsp;|&nbsp;
        LOG: /var/log/security/access_block_{{ now()->format('Ymd') }}.log
    </p>
</div>
</body>
</html>
