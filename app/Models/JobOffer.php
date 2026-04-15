<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'location',
        'type',
        'deadline',
        'is_active',
    ];

    protected $casts = [
        'deadline'  => 'date',
        'is_active' => 'boolean',
    ];

    // Relation : une offre a plusieurs candidatures
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // Scope pour les offres actives et non expirées
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('deadline', '>=', now()->toDateString());
    }

    // Vérifier si l'offre est expirée
    public function getIsExpiredAttribute(): bool
    {
        return $this->deadline->isPast();
    }
}
