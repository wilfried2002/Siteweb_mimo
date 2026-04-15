@extends('layouts.admin')
@section('title', 'Candidatures')
@section('page-title', 'Gestion des Candidatures')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h5><i class="bi bi-people me-2" style="color:var(--admin-secondary);"></i>Candidatures Reçues</h5>
        <span class="badge" style="background:var(--admin-secondary); color:#000; font-size:.8rem; padding:.4rem .9rem;">
            {{ $applications->total() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Poste</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <div style="font-weight:600; font-size:.9rem;">{{ $app->full_name }}</div>
                            <div style="font-size:.75rem; color:#94a3b8;">{{ $app->email }}</div>
                            @if($app->phone)
                                <div style="font-size:.75rem; color:#94a3b8;">{{ $app->phone }}</div>
                            @endif
                        </td>
                        <td class="small">{{ $app->jobOffer->title ?? '—' }}</td>
                        <td class="small text-muted">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge badge-{{ $app->status }}"
                                  style="font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">
                                {{ $app->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.applications.show', $app) }}"
                                   class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.applications.cv', $app) }}"
                                   class="btn btn-sm btn-outline-success" title="Télécharger CV">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.applications.destroy', $app) }}"
                                      onsubmit="return confirm('Supprimer cette candidature ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2.5rem; display:block; margin-bottom:.5rem;"></i>
                            Aucune candidature reçue
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid #f0f0f0;">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
