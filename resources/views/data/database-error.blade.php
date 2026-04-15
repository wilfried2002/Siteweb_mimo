<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#fefefe;--border:#ddd;--red:#c0392b;--orange:#e67e22;--blue:#2980b9;--text:#222;--muted:#777;--code-bg:#f5f5f5}
        body{background:#f0f0f0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:var(--text);min-height:100vh;padding:0}
        /* Classic PHP error header */
        .php-header{background:#fff;border-bottom:3px solid var(--red);padding:1rem 1.5rem;display:flex;align-items:center;gap:1rem}
        .php-header .logo{font-size:1.5rem;font-weight:900;color:var(--blue);letter-spacing:-1px}
        .php-header .logo span{color:var(--red)}
        .php-header .version{font-size:.75rem;color:var(--muted);border-left:1px solid #ddd;padding-left:1rem;margin-left:.5rem}
        /* Error container */
        .container{max-width:900px;margin:2rem auto;padding:0 1rem}
        /* Error block */
        .error-block{background:#fff;border:1px solid var(--border);border-left:5px solid var(--red);border-radius:3px;margin-bottom:1.2rem;overflow:hidden}
        .error-block.warning{border-left-color:var(--orange)}
        .error-title{background:var(--red);color:#fff;padding:.55rem 1rem;font-size:.88rem;font-weight:700}
        .error-block.warning .error-title{background:var(--orange)}
        .error-body{padding:1rem 1.2rem}
        .error-type{font-size:.85rem;font-weight:700;color:var(--red);margin-bottom:.5rem}
        .error-block.warning .error-type{color:var(--orange)}
        .error-msg{font-size:.88rem;color:#333;line-height:1.6;margin-bottom:.8rem}
        .error-msg code{background:var(--code-bg);padding:.1rem .3rem;border-radius:2px;font-family:'Courier New',monospace;font-size:.85em;color:#c0392b;border:1px solid #e0e0e0}
        .error-loc{font-size:.78rem;color:var(--muted);font-family:'Courier New',monospace}
        .error-loc strong{color:#333}
        /* Stack trace */
        .stack{background:var(--code-bg);border:1px solid var(--border);border-radius:3px;padding:1rem;font-family:'Courier New',monospace;font-size:.74rem;color:#555;line-height:1.7;overflow-x:auto;margin-top:.8rem}
        .stack .frame-num{color:#aaa;margin-right:.5rem}
        .stack .frame-file{color:var(--blue)}
        .stack .frame-fn{color:var(--orange)}
        /* Server info */
        .server-info{background:#fff;border:1px solid var(--border);border-radius:3px;margin-bottom:1.2rem}
        .server-info table{width:100%;border-collapse:collapse;font-size:.78rem}
        .server-info th{background:#f5f5f5;text-align:left;padding:.5rem .8rem;border-bottom:1px solid var(--border);color:var(--muted);font-size:.72rem;text-transform:uppercase;letter-spacing:.5px;font-weight:700}
        .server-info td{padding:.45rem .8rem;border-bottom:1px solid #f0f0f0;color:#555}
        .server-info td:first-child{color:#333;width:35%;font-weight:600}
        .val-red{color:var(--red)!important;font-weight:700}
        /* Footer */
        .php-footer{text-align:center;font-size:.72rem;color:#aaa;padding:1.5rem;border-top:1px solid #e0e0e0;margin-top:1rem}
    </style>
</head>
<body>
<div class="php-header">
    <div class="logo">PHP<span>/</span>Apache</div>
    <div class="version">PHP 8.2.12 &nbsp;|&nbsp; Apache/2.4.57 (Debian) &nbsp;|&nbsp; MySQL 8.0.35</div>
</div>

<div class="container">

    <!-- Fatal error -->
    <div class="error-block">
        <div class="error-title">&#9888; Fatal Error — Database Connection Failed</div>
        <div class="error-body">
            <div class="error-type">PDOException: SQLSTATE[HY000] [2002] Connection refused</div>
            <div class="error-msg">
                Uncaught exception <code>PDOException</code> with message
                <code>SQLSTATE[HY000] [2002] Connection refused</code> in
                <code>/var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:79</code>
            </div>
            <div class="error-loc">
                <strong>File:</strong> /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php &nbsp;
                <strong>Line:</strong> 79
            </div>
            <div class="stack">
<span class="frame-num">#0</span> <span class="frame-file">/var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/MySqlConnector.php</span>(<span class="frame-fn">58</span>): PDO::__construct('mysql:host=127....', 'db_user', '***', Array)
<span class="frame-num">#1</span> <span class="frame-file">/var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/ConnectionFactory.php</span>(<span class="frame-fn">182</span>): Illuminate\Database\Connectors\MySqlConnector->connect(Array)
<span class="frame-num">#2</span> <span class="frame-file">/var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/ConnectionFactory.php</span>(<span class="frame-fn">116</span>): Illuminate\Database\Connectors\ConnectionFactory->createPdoConnection('mysql:host=127....', 'db_user', '***', Array)
<span class="frame-num">#3</span> <span class="frame-file">/var/www/html/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php</span>(<span class="frame-fn">241</span>): Illuminate\Database\Connectors\ConnectionFactory->make(Array, 'mysql')
<span class="frame-num">#4</span> <span class="frame-file">/var/www/html/public/index.php</span>(<span class="frame-fn">58</span>): Illuminate\Foundation\Application->handleRequest(Object(Illuminate\Http\Request))
<span class="frame-num">#5</span> <span class="frame-file">{main}</span> thrown in <span class="frame-file">/var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php</span> on line <strong>79</strong>
            </div>
        </div>
    </div>

    <!-- Warning -->
    <div class="error-block warning">
        <div class="error-title">&#9888; Warning — Retry Attempt Failed</div>
        <div class="error-body">
            <div class="error-type">RuntimeException: Max reconnection attempts reached (3/3)</div>
            <div class="error-msg">
                Database host <code>127.0.0.1:3306</code> is unreachable.
                All connection retry attempts have been exhausted.
                Check that your MySQL/MariaDB service is running and accepting connections.
            </div>
            <div class="error-loc">
                <strong>File:</strong> /var/www/html/app/Providers/AppServiceProvider.php &nbsp;
                <strong>Line:</strong> 42
            </div>
        </div>
    </div>

    <!-- Server environment -->
    <div class="server-info">
        <table>
            <tr><th colspan="2">Environment &amp; Server Details</th></tr>
            <tr><td>DB_HOST</td><td class="val-red">127.0.0.1 — UNREACHABLE</td></tr>
            <tr><td>DB_PORT</td><td>3306 (default)</td></tr>
            <tr><td>DB_CONNECTION</td><td>mysql</td></tr>
            <tr><td>MySQL Status</td><td class="val-red">DOWN — Connection refused (errno 111)</td></tr>
            <tr><td>PHP Version</td><td>8.2.12 (cli)</td></tr>
            <tr><td>Server</td><td>Apache/2.4.57 (Debian)</td></tr>
            <tr><td>Request URI</td><td>{{ request()->getRequestUri() }}</td></tr>
            <tr><td>Timestamp</td><td>{{ now()->toIso8601String() }}</td></tr>
        </table>
    </div>

</div>

<div class="php-footer">
    Internal Server Error — Request ID: {{ strtoupper(substr(md5(microtime()),0,20)) }} &nbsp;|&nbsp;
    Please contact your system administrator.
</div>
</body>
</html>
