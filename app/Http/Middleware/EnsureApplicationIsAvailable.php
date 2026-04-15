<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicationIsAvailable
{
    /** Chemins toujours accessibles */
    private array $allowedPaths = [
        'system/status',
        'system/status/update',
        'admin/login',
    ];

    /** Correspondance mode → vue */
    private array $errorViews = [
        'service_unavailable' => 'data.service-unavailable',
        'account_suspended'   => 'data.account-suspended',
        'security_lock'       => 'data.security-lock',
        'database_error'      => 'data.database-error',
        'maintenance'         => 'data.maintenance',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!SystemSetting::isApplicationActive()) {

                // Chemins whitelistés
                foreach ($this->allowedPaths as $path) {
                    if ($request->is($path)) {
                        return $next($request);
                    }
                }

                // Clé secrète .env
                $secretKey = config('app.maintenance_key');
                if ($secretKey && $request->query('key') === $secretKey) {
                    return $next($request);
                }

                // Choisir la vue selon le mode d'erreur
                $errorMode = SystemSetting::get('error_mode', 'service_unavailable');
                $view      = $this->errorViews[$errorMode] ?? 'data.service-unavailable';

                return response()
                    ->view($view, [], 503)
                    ->header('Retry-After', '3600')
                    ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            }
        } catch (\Throwable) {
            // DB inaccessible : laisser passer
        }

        return $next($request);
    }
}
