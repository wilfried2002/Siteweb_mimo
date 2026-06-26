<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_offer_id',
        'desired_position',
        'first_name',
        'last_name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'lettre_path',
        'status',
    ];

    // Relation : une candidature appartient à une offre
    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    // Nom complet du candidat
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Labels de statut traduits
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'En attente',
            'reviewed' => 'En cours d\'examen',
            'accepted' => 'Acceptée',
            'rejected' => 'Rejetée',
            default    => 'Inconnu',
        };
    }

    // Couleur badge Bootstrap selon statut
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'warning',
            'reviewed' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }
}
