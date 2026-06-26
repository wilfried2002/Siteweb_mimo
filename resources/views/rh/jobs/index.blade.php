@extends('layouts.workspace')
@section('title', "Offres d'emploi — RH")
@section('page-title', "Offres d'emploi")

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Ressources Humaines</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.rh.applications.*') ? 'active' : '' }}"
           href="{{ route('employee.rh.applications.index') }}">
            <i class="bi bi-people"></i> Candidatures
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.rh.jobs.index') }}">
            <i class="bi bi-briefcase"></i> Offres d'emploi
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="color:var(--ws-primary);">Offres d'emploi</h5>
    <a href="{{ route('employee.rh.jobs.create') }}" class="btn btn-ws">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle offre
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Localisation</th>
                    <th>Clôture</th>
                    <th>Candidatures</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td class="fw-semibold">{{ $job->title }}</td>
                    <td class="text-muted small">{{ $job->type }}</td>
                    <td class="text-muted small">{{ $job->location }}</td>
                    <td class="text-muted small">{{ $job->deadline->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill" style="background:#dbeafe;color:#1e40af;">
                            {{ $job->applications_count }}
                        </span>
                    </td>
                    <td>
                        @if($job->is_active && !$job->is_expired)
                            <span class="badge" style="background:#d1fae5;color:#065f46;">Active</span>
                        @elseif($job->is_expired)
                            <span class="badge" style="background:#fee2e2;color:#991b1b;">Expirée</span>
                        @else
                            <span class="badge" style="background:#f1f5f9;color:#64748b;">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('employee.rh.jobs.edit', $job) }}"
                               class="btn btn-sm btn-outline-secondary py-0 px-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('employee.rh.jobs.destroy', $job) }}"
                                  onsubmit="return confirm('Supprimer cette offre ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger py-0 px-2">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune offre créée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jobs->hasPages())
    <div class="px-4 py-3">{{ $jobs->links() }}</div>
    @endif
</div>
@endsection
