<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'city',
        'address',
        'type',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    // ── Relations ──────────────────────────────────────────
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Accessors ──────────────────────────────────────────

    /** Label traduit du statut */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'En attente',
            'validated' => 'Validée',
            'cancelled' => 'Annulée',
            default     => 'Inconnu',
        };
    }

    /** Couleur Bootstrap du badge statut */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'validated' => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }

    /** Couleur CSS inline pour badge statut (admin) */
    public function getStatusBgAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'background:#fef3c7;color:#92400e',
            'validated' => 'background:#d1fae5;color:#065f46',
            'cancelled' => 'background:#fee2e2;color:#991b1b',
            default     => 'background:#f1f5f9;color:#475569',
        };
    }

    /** Label traduit du type */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'gros' ? 'Commande en Gros' : 'Commande en Détail';
    }

    /** Nombre total d'articles */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    // ── Scopes ─────────────────────────────────────────────
    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeGros($query)      { return $query->where('type', 'gros'); }
    public function scopeDetail($query)    { return $query->where('type', 'detail'); }
}
