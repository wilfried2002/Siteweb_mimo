<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SystemStatusController extends Controller
{
    /** Labels lisibles pour les modes d'erreur */
    public const ERROR_MODES = [
        'service_unavailable' => '503 — Service indisponible (panne serveur)',
        'account_suspended'   => 'Compte suspendu (message hébergeur)',
        'security_lock'       => 'Verrouillage sécurité (incident critique)',
        'database_error'      => 'Erreur base de données (stack trace PHP)',
        'maintenance'         => 'Maintenance planifiée (compte à rebours)',
    ];

    public function index()
    {
        $status    = SystemSetting::get('application_status', 'active');
        $errorMode = SystemSetting::get('error_mode', 'service_unavailable');
        $updatedAt = SystemSetting::where('key', 'application_status')->value('updated_at');

        return view('system.status', [
            'status'     => $status,
            'errorMode'  => $errorMode,
            'errorModes' => self::ERROR_MODES,
            'updatedAt'  => $updatedAt,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'status'     => ['required', 'in:active,inactive'],
            'error_mode' => ['required', 'in:' . implode(',', array_keys(self::ERROR_MODES))],
        ]);

        $prevStatus = SystemSetting::get('application_status', 'active');

        SystemSetting::set('application_status', $request->status);
        SystemSetting::set('error_mode',         $request->error_mode);

        Log::info('system.availability_changed', [
            'from'       => $prevStatus,
            'to'         => $request->status,
            'error_mode' => $request->error_mode,
            'operator'   => auth()->user()?->email ?? 'anonymous',
            'ip'         => $request->ip(),
        ]);

        $label = $request->status === 'active' ? 'activée' : 'désactivée';

        return redirect()
            ->route('system.status')
            ->with('success', "Application {$label}. Mode : " . self::ERROR_MODES[$request->error_mode]);
    }
}
