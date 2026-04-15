<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Lire une valeur de configuration.
     */
    public static function get(string $key, string $default = ''): string
    {
        return Cache::remember("sys_setting_{$key}", 60, function () use ($key, $default) {
            $row = static::where('key', $key)->first();
            return $row ? $row->value : $default;
        });
    }

    /**
     * Écrire / mettre à jour une valeur.
     */
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("sys_setting_{$key}");
    }

    /**
     * L'application est-elle opérationnelle ?
     */
    public static function isApplicationActive(): bool
    {
        return static::get('application_status', 'active') === 'active';
    }
}
