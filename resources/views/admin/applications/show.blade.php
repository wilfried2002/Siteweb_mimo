@extends('layouts.admin')
@section('title', 'Candidature')
@section('page-title', 'Détail de la Candidature')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="form-card">
            <div class="d-flex align-items-center gap-4 mb-4">
                <div style="width:65px; height:65px; background:var(--admin-primary); border-radius:50%;
                            display:flex; align-items:center; justify-content:center; font-size:1.6rem; font-weight:700; color:var(--admin-secondary); font-family:'Montserrat',sans-serif;">
                    {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                </div>
                <div>
                    <h4 style="color:var(--admin-primary); margin:0;">{{ $application->full_name }}</h4>
                    <div style="color:#94a3b8; font-size:.85rem;">
                        {{ $application->email }}
                        @if($application->phone) · {{ $application->phone }} @endif
                    </div>
                    <span class="badge badge-{{ $application->status }}"
                          style="font-size:.75rem; padding:.35rem .8rem; border-radius:20px; margin-top:.3rem;">
                        {{ $application->status_label }}
                    </span>
                </div>
            </div>

            <div style="background:#f8fafc; border-radius:8px; padding:1.2rem; margin-bottom:1.5rem;">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="small text-muted">Poste visé</div>
                        <div class="fw-bold" style="color:var(--admin-primary);">
                            {{ $application->jobOffer->title ?? '—' }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Type de contrat</div>
                        <div class="fw-bold">{{ $application->jobOffer->type ?? '—' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Date de candidature</div>
                        <div class="fw-bold">{{ $application->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Localisation du poste</div>
                        <div class="fw-bold">{{ $application->jobOffer->location ?? '—' }}</div>
                    </div>
                </div>
            </div>

            @if($application->cover_letter)
                <h6 style="color:var(--admin-primary); border-bottom:2px solid var(--admin-secondary); padding-bottom:.5rem; margin-bottom:1rem;">
                    Lettre de Motivation
                </h6>
                <p class="text-muted small" style="line-height:2; white-space:pre-wrap;">{{ $application->cover_letter }}</p>
            @endif

            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('admin.applications.cv', $application) }}"
                   class="btn btn-admin">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Télécharger le CV
                </a>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="form-card">
            <h6 style="color:var(--admin-primary); margin-bottom:1.2rem;">
                <i class="bi bi-arrow-repeat me-2" style="color:var(--admin-secondary);"></i>
                Mettre à jour le statut
            </h6>
            <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="form-label">Statut de la candidature</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending'=>'En attente','reviewed'=>'En cours d\'examen','accepted'=>'Acceptée','rejected'=>'Rejetée'] as $val => $label)
                            <option value="{{ $val }}" {{ $application->status === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-admin w-100">
                    <i class="bi bi-save me-2"></i>Enregistrer le statut
                </button>
            </form>

            <hr style="margin: 1.5rem 0;">

            <div style="background:#f8fafc; border-radius:8px; padding:1.2rem;">
                <h6 style="color:var(--admin-primary);">Légende des statuts</h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2"><span class="badge badge-pending" style="border-radius:20px; padding:.3rem .7rem;">En attente</span> — Candidature non traitée</li>
                    <li class="mb-2"><span class="badge badge-reviewed" style="border-radius:20px; padding:.3rem .7rem;">En examen</span> — RH en cours d'évaluation</li>
                    <li class="mb-2"><span class="badge badge-accepted" style="border-radius:20px; padding:.3rem .7rem;">Acceptée</span> — Candidature retenue</li>
                    <li><span class="badge badge-rejected" style="border-radius:20px; padding:.3rem .7rem;">Rejetée</span> — Ne correspond pas au profil</li>
                </ul>
            </div>

            <hr style="margin: 1.5rem 0;">
            <form method="POST"
                  action="{{ route('admin.applications.destroy', $application) }}"
                  onsubmit="return confirm('Supprimer définitivement cette candidature ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash me-2"></i>Supprimer cette candidature
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
