<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware global : vérifie la disponibilité de l'application
        $middleware->append(\App\Http\Middleware\EnsureApplicationIsAvailable::class);

        // Rediriger selon le préfixe de l'URL demandée
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if (str_starts_with($request->path(), 'espace/')) {
                return route('employee.login');
            }
            return route('admin.login');
        });

        $middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Sur hébergement cPanel, public_html/ est la racine (pas de sous-dossier public/)
// public_path() doit pointer sur la racine pour que file_exists() et asset() fonctionnent
if (!is_dir(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public')) {
    $app->usePublicPath(dirname(__DIR__));
}

return $app;
