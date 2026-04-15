@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Tableau de Bord')

@section('content')

{{-- Stats Cards --}}
<div class="row g-4 mb-4">
    @foreach([
        ['label'=>'Produits','value'=>$stats['products'],'icon'=>'bi-bag','color'=>'#1a3a5c','bg'=>'#e8f4f8'],
        ['label'=>'Offres actives','value'=>$stats['jobs'],'icon'=>'bi-briefcase','color'=>'#c8a84b','bg'=>'#fef9ec'],
        ['label'=>'Candidatures','value'=>$stats['applications'],'icon'=>'bi-people','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
        ['label'=>'En attente','value'=>$stats['pending'],'icon'=>'bi-clock','color'=>'#f97316','bg'=>'#fff7ed'],
    ] as $stat)
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size:.78rem; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; font-weight:600; font-family:'Montserrat',sans-serif;">
                            {{ $stat['label'] }}
                        </div>
                        <div style="font-size:2.2rem; font-weight:800; color:var(--admin-primary); font-family:'Montserrat',sans-serif; line-height:1.2; margin-top:.3rem;">
                            {{ $stat['value'] }}
                        </div>
                    </div>
                    <div class="icon" style="background:{{ $stat['bg'] }};">
                        <i class="bi {{ $stat['icon'] }}" style="color:{{ $stat['color'] }}; font-size:1.4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Liens rapides --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-header">
                <h5><i class="bi bi-people me-2 text-gold" style="color:var(--admin-secondary);"></i>Candidatures Récentes</h5>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Candidat</th>
                            <th>Poste</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $app)
                            <tr>
                                <td>
                                    <div style="font-weight:600; font-size:.9rem;">{{ $app->full_name }}</div>
                                    <div style="font-size:.78rem; color:#94a3b8;">{{ $app->email }}</div>
                                </td>
                                <td class="small">{{ $app->jobOffer->title ?? '—' }}</td>
                                <td class="small text-muted">{{ $app->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $app->status }}" style="font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">
                                        {{ $app->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $app) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:.5rem;"></i>
                                    Aucune candidature pour le moment
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="table-card h-100">
            <div class="table-header">
                <h5><i class="bi bi-lightning me-2" style="color:var(--admin-secondary);"></i>Actions Rapides</h5>
            </div>
            <div style="padding: 1.5rem;">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-admin">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter un produit
                    </a>
                    <a href="{{ route('admin.jobs.create') }}" class="btn btn-admin">
                        <i class="bi bi-plus-circle me-2"></i>Créer une offre d'emploi
                    </a>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-admin">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter un slider
                    </a>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-people me-2"></i>Gérer les candidatures
                    </a>
                </div>

                <hr style="margin:1.5rem 0;">
                <div style="background:#f8fafc; border-radius:8px; padding:1rem;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-clock text-warning"></i>
                        <span style="font-size:.85rem; font-weight:600;">Candidatures en attente</span>
                    </div>
                    <div style="font-size:2rem; font-weight:800; color:var(--admin-primary);">
                        {{ $stats['pending'] }}
                    </div>
                    @if($stats['pending'] > 0)
                        <a href="{{ route('admin.applications.index') }}"
                           class="btn btn-sm btn-warning mt-2" style="font-size:.78rem;">
                            Traiter maintenant →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
