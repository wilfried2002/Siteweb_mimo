<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;min-height:100vh;display:flex;flex-direction:column}
        /* Provider top bar */
        .provider-bar{background:#1a1a2e;padding:.7rem 2rem;display:flex;align-items:center;justify-content:space-between}
        .provider-logo{color:#fff;font-size:1.1rem;font-weight:700;letter-spacing:1px}
        .provider-logo span{color:#e94560}
        .provider-bar .links a{color:rgba(255,255,255,.55);font-size:.78rem;text-decoration:none;margin-left:1.2rem}
        /* Main */
        .main{flex:1;display:flex;align-items:center;justify-content:center;padding:3rem 1rem}
        .card{background:#fff;border:1px solid #ddd;border-radius:4px;max-width:680px;width:100%;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08)}
        /* Card header */
        .card-header{background:#c0392b;padding:1.5rem 2rem;display:flex;align-items:center;gap:1rem}
        .card-header .icon{width:50px;height:50px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;flex-shrink:0}
        .card-header h1{color:#fff;font-size:1.3rem;font-weight:700}
        .card-header p{color:rgba(255,255,255,.8);font-size:.82rem;margin-top:.2rem}
        /* Card body */
        .card-body{padding:2rem}
        .notice-box{background:#fdf2f2;border:1px solid #f5c6cb;border-left:4px solid #c0392b;border-radius:3px;padding:1.2rem 1.5rem;margin-bottom:1.5rem}
        .notice-box p{color:#721c24;font-size:.88rem;line-height:1.7}
        .notice-box strong{display:block;margin-bottom:.4rem;font-size:.92rem}
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem}
        .info-item{background:#f8f9fa;border:1px solid #e9ecef;border-radius:3px;padding:.9rem 1rem}
        .info-item .label{font-size:.68rem;color:#6c757d;text-transform:uppercase;letter-spacing:1px;font-weight:700}
        .info-item .value{font-size:.88rem;color:#212529;margin-top:.3rem;font-weight:600}
        .info-item .value.danger{color:#c0392b}
        .steps{margin-bottom:1.5rem}
        .steps h3{font-size:.88rem;color:#212529;font-weight:700;margin-bottom:.8rem;text-transform:uppercase;letter-spacing:.5px}
        .step{display:flex;gap:.9rem;align-items:flex-start;margin-bottom:.7rem}
        .step-num{width:22px;height:22px;background:#c0392b;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;margin-top:.1rem}
        .step p{font-size:.83rem;color:#495057;line-height:1.6}
        .contact-bar{background:#f8f9fa;border:1px solid #e9ecef;border-radius:3px;padding:1rem 1.2rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.8rem}
        .contact-bar p{font-size:.82rem;color:#495057}
        .contact-bar a{background:#c0392b;color:#fff;padding:.45rem 1.1rem;border-radius:3px;font-size:.8rem;text-decoration:none;font-weight:700}
        /* Footer */
        .provider-footer{background:#1a1a2e;padding:.9rem 2rem;text-align:center}
        .provider-footer p{color:rgba(255,255,255,.35);font-size:.72rem}
        @media(max-width:560px){.info-grid{grid-template-columns:1fr}.contact-bar{flex-direction:column}.provider-bar .links{display:none}}
    </style>
</head>
<body>
<div class="provider-bar">
    <div class="provider-logo">NET<span>HOST</span> PRO</div>
    <div class="links">
        <a href="#">Support</a>
        <a href="#">Client Area</a>
        <a href="#">Status</a>
    </div>
</div>

<div class="main">
    <div class="card">
        <div class="card-header">
            <div class="icon">⛔</div>
            <div>
                <h1>Account Suspended</h1>
                <p>This hosting account has been suspended and is no longer accessible.</p>
            </div>
        </div>
        <div class="card-body">
            <div class="notice-box">
                <strong>&#9888; Important Notice</strong>
                <p>The hosting account associated with this domain has been <strong>suspended</strong>.
                   Access to all services on this account, including websites, emails, and databases,
                   has been restricted until the suspension is resolved.</p>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Account Status</div>
                    <div class="value danger">SUSPENDED</div>
                </div>
                <div class="info-item">
                    <div class="label">Ticket Reference</div>
                    <div class="value">#{{ rand(100000,999999) }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Suspension Date</div>
                    <div class="value">{{ now()->format('d M Y, H:i') }} UTC</div>
                </div>
                <div class="info-item">
                    <div class="label">Account Type</div>
                    <div class="value">Shared Hosting — Business</div>
                </div>
            </div>

            <div class="steps">
                <h3>How to restore your account</h3>
                <div class="step">
                    <div class="step-num">1</div>
                    <p>Log in to your <strong>Client Area</strong> to view the suspension reason and any outstanding invoices.</p>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <p>Resolve the issue indicated in the suspension notice (unpaid invoice, ToS violation, abuse report, etc.).</p>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <p>Contact our <strong>Billing or Abuse department</strong> with your ticket reference for reactivation.</p>
                </div>
            </div>

            <div class="contact-bar">
                <p>Need help? Our support team is available 24/7.</p>
                <a href="#">Open Support Ticket</a>
            </div>
        </div>
    </div>
</div>

<div class="provider-footer">
    <p>&copy; {{ date('Y') }} NetHost Pro — Hosting Solutions. All rights reserved. &nbsp;|&nbsp; support@nethostpro.example</p>
</div>
</body>
</html>
