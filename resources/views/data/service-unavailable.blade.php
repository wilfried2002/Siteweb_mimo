<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Service Unavailable</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0d0d0d;--surface:#151515;--border:#222;--text:#bbb;--muted:#444;--red:#c0392b;--amber:#d68910}
        body{background:var(--bg);color:var(--text);font-family:'Courier New',monospace;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem}
        .header{text-align:center;margin-bottom:2.5rem}
        .code{font-size:clamp(4rem,10vw,6.5rem);font-weight:900;color:var(--red);letter-spacing:-3px;line-height:1;text-shadow:0 0 50px rgba(192,57,43,.4)}
        .title{font-size:1rem;color:var(--text);margin-top:.6rem;letter-spacing:4px;text-transform:uppercase}
        .subtitle{font-size:.75rem;color:var(--muted);margin-top:.3rem;letter-spacing:1px}
        .panel{width:100%;max-width:700px;border:1px solid var(--border);border-radius:3px;overflow:hidden}
        .panel-bar{background:#1a1a1a;border-bottom:1px solid var(--border);padding:.55rem 1rem;font-size:.7rem;color:var(--muted);display:flex;align-items:center;gap:.7rem}
        .dot-red{width:8px;height:8px;border-radius:50%;background:var(--red);box-shadow:0 0 5px var(--red)}
        .panel-body{background:#0a0a0a;padding:1.4rem 1.2rem}
        .line{font-size:.74rem;line-height:1.95;display:flex;gap:.9rem}
        .ts{color:#333;white-space:nowrap;min-width:115px}
        .lvl{min-width:52px;font-weight:700}
        .lvl.e{color:var(--red)}.lvl.w{color:var(--amber)}.lvl.i{color:#336699}
        .msg{color:#666}
        hr.sep{border:none;border-top:1px solid #1e1e1e;margin:.9rem 0}
        table{width:100%;border-collapse:collapse;font-size:.73rem}
        td{padding:.4rem .2rem;border-bottom:1px solid #111;color:#555}
        td:first-child{color:#333;width:42%}
        .fail{color:var(--red)!important}.warn{color:var(--amber)!important}
        .foot{margin-top:1.8rem;font-size:.7rem;color:#252525;text-align:center;letter-spacing:.8px}
        .sub{margin-top:1rem;font-size:.76rem;color:#333;text-align:center}
    </style>
</head>
<body>
<div class="header">
    <div class="code">503</div>
    <div class="title">Service Unavailable</div>
    <div class="subtitle">The server is temporarily unable to service your request due to maintenance downtime or capacity problems</div>
</div>
<div class="panel">
    <div class="panel-bar">
        <span class="dot-red"></span>
        nginx/1.24.0 &nbsp;|&nbsp; upstream_error.log &nbsp;|&nbsp; {{ now()->format('D, d M Y H:i:s') }} GMT
    </div>
    <div class="panel-body">
        @php $base = now(); @endphp
        <div class="line"><span class="ts">{{ $base->format('H:i:s.') }}{{ rand(100,999) }}</span><span class="lvl e">ERROR</span><span class="msg">connect() failed (111: Connection refused) while connecting to upstream, client: {{ request()->ip() }}</span></div>
        <div class="line"><span class="ts">{{ $base->copy()->subSeconds(1)->format('H:i:s.') }}{{ rand(100,999) }}</span><span class="lvl e">ERROR</span><span class="msg">upstream timed out (110: Connection timed out) reading response header from upstream</span></div>
        <div class="line"><span class="ts">{{ $base->copy()->subSeconds(2)->format('H:i:s.') }}{{ rand(100,999) }}</span><span class="lvl w">WARN</span><span class="msg">upstream server temporarily disabled while reading response header</span></div>
        <div class="line"><span class="ts">{{ $base->copy()->subSeconds(3)->format('H:i:s.') }}{{ rand(100,999) }}</span><span class="lvl w">WARN</span><span class="msg">retrying upstream request, attempt 3/3 — all peers marked as down</span></div>
        <div class="line"><span class="ts">{{ $base->copy()->subSeconds(4)->format('H:i:s.') }}{{ rand(100,999) }}</span><span class="lvl i">INFO</span><span class="msg">returning 503 to client — retry-after: 3600s</span></div>
        <hr class="sep">
        <table>
            <tr><td>Request-ID</td><td>{{ strtoupper(substr(md5(microtime()),0,16)) }}-{{ rand(1000,9999) }}</td></tr>
            <tr><td>Upstream status</td><td class="fail">UNREACHABLE — 0/3 backends alive</td></tr>
            <tr><td>Connection timeout</td><td class="warn">30 000 ms exceeded</td></tr>
            <tr><td>Load balancer</td><td class="fail">DEGRADED — automatic failover in progress</td></tr>
            <tr><td>Retry-After</td><td>3600 s</td></tr>
            <tr><td>Timestamp</td><td>{{ now()->toIso8601String() }}</td></tr>
        </table>
    </div>
</div>
<p class="sub">Please try again later. If the problem persists, contact the system administrator.</p>
<p class="foot">INCIDENT-REF: {{ strtoupper(substr(md5(request()->ip().now()->timestamp),0,28)) }}</p>
</body>
</html>
