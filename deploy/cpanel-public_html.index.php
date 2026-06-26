<?php

// ============================================================
// Point d'entrée pour hébergement partagé (cPanel) où le
// DocumentRoot ne peut PAS être changé vers le dossier "public/".
//
// Placer ce fichier dans public_html/index.php (en remplacement
// du contenu généré par public/index.php) et copier également
// public_html/.htaccess (voir cpanel-public_html.htaccess) ainsi
// que le contenu du dossier public/ (assets, build, images, ...)
// dans public_html/.
//
// Le reste du code Laravel (app/, bootstrap/, config/, routes/,
// vendor/, etc.) doit être placé dans un dossier HORS de
// public_html, par exemple : /home/USER/mimosaflour
// ============================================================

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Chemin absolu vers la racine de l'application Laravel
// (à adapter selon l'emplacement réel sur le serveur cPanel)
$appBasePath = '/home/USER/mimosaflour';

// Mode maintenance
if (file_exists($maintenance = $appBasePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appBasePath.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appBasePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
