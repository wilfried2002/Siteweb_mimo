@extends('layouts.admin')
@section('title', "Offres d'emploi")
@section('page-title', "Gestion des Offres d'Emploi")

@section('content')
<div class="table-card">
    <div class="table-header">
        <h5><i class="bi bi-briefcase me-2" style="color:var(--admin-secondary);"></i>Offres d'Emploi</h5>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-admin">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle offre
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Localisation</th>
                    <th>Date limite</th>
                    <th>Candidatures</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <div style="font-weight:600; font-size:.9rem;">{{ $job->title }}</div>
                            <div style="font-size:.75rem; color:#94a3b8;">
                                {{ Str::limit($job->description, 60) }}
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $job->type }}</span></td>
                        <td class="small">{{ $job->location }}</td>
                        <td class="small">
                            <span class="{{ $job->deadline->isPast() ? 'text-danger' : 'text-dark' }}">
                                {{ $job->deadline->format('d/m/Y') }}
                                @if($job->deadline->isPast())
                                    <span class="badge badge-rejected ms-1">Expirée</span>
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="badge" style="background:#dbeafe; color:#1e40af; font-size:.8rem; padding:.4rem .8rem;">
                                {{ $job->applications_count }}
                            </span>
                        </td>
                        <td>
                            @if($job->is_active)
                                <span class="badge" style="background:#d1fae5; color:#065f46; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Actif</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.jobs.edit', $job) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.jobs.destroy', $job) }}"
                                      onsubmit="return confirm('Supprimer cette offre et toutes ses candidatures ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-briefcase" style="font-size:2.5rem; display:block; margin-bottom:.5rem;"></i>
                            Aucune offre d'emploi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jobs->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid #f0f0f0;">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
