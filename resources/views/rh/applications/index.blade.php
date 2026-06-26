@extends('layouts.workspace')
@section('title', 'Candidatures — RH')
@section('page-title', 'Gestion des Candidatures')

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Ressources Humaines</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.rh.applications.*') ? 'active' : '' }}"
           href="{{ route('employee.rh.applications.index') }}">
            <i class="bi bi-people"></i> Candidatures
            @if($stats['pending'] > 0)
                <span class="badge rounded-pill ms-auto"
                      style="background:var(--ws-secondary);color:#000;font-size:.62rem;">
                    {{ $stats['pending'] }}
                </span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.rh.jobs.*') ? 'active' : '' }}"
           href="{{ route('employee.rh.jobs.index') }}">
            <i class="bi bi-briefcase"></i> Offres d'emploi
        </a>
    </li>
</ul>
@endsection

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'En attente','value'=>$stats['pending'],'color'=>'#fef3c7','text'=>'#92400e','icon'=>'bi-hourglass'],
        ['label'=>'En examen','value'=>$stats['reviewed'],'color'=>'#dbeafe','text'=>'#1e40af','icon'=>'bi-eye'],
        ['label'=>'Acceptées','value'=>$stats['accepted'],'color'=>'#d1fae5','text'=>'#065f46','icon'=>'bi-check-circle'],
        ['label'=>'Rejetées','value'=>$stats['rejected'],'color'=>'#fee2e2','text'=>'#991b1b','icon'=>'bi-x-circle'],
    ] as $s)
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:10px;background:{{ $s['color'] }};
                        display:flex;align-items:center;justify-content:center;">
                <i class="bi {{ $s['icon'] }}" style="color:{{ $s['text'] }};font-size:1.1rem;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:var(--ws-primary);">{{ $s['value'] }}</div>
                <div class="text-muted small">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filtres --}}
<div class="form-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Tous</option>
                @foreach(['pending'=>'En attente','reviewed'=>'En examen','accepted'=>'Acceptées','rejected'=>'Rejetées'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label">Recherche</label>
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Nom, email…" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-ws">Filtrer</button>
        </div>
        @if(request()->hasAny(['status','search']))
        <div class="col-md-2">
            <a href="{{ route('employee.rh.applications.index') }}" class="btn btn-sm btn-outline-secondary w-100">Réinitialiser</a>
        </div>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="tc-header">
        <h5><i class="bi bi-people me-2"></i>Candidatures ({{ $applications->total() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Poste / Offre</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $app->full_name }}</div>
                        <div class="text-muted small">{{ $app->email }}</div>
                    </td>
                    <td>
                        @if($app->jobOffer)
                            <div class="small fw-semibold">{{ $app->jobOffer->title }}</div>
                        @elseif($app->desired_position)
                            <div class="small text-muted">
                                <i class="bi bi-person-plus me-1"></i>Spontanée : {{ $app->desired_position }}
                            </div>
                        @else
                            <span class="text-muted small">Candidature spontanée</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $colors = ['pending'=>'#fef3c7::#92400e','reviewed'=>'#dbeafe::#1e40af','accepted'=>'#d1fae5::#065f46','rejected'=>'#fee2e2::#991b1b'];
                            [$bg,$tc] = explode('::', $colors[$app->status] ?? '#f1f5f9::#475569');
                        @endphp
                        <span class="badge rounded-pill" style="background:{{ $bg }};color:{{ $tc }};">
                            {{ $app->status_label }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $app->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('employee.rh.applications.show', $app) }}"
                           class="btn btn-sm btn-outline-primary py-0 px-2">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune candidature.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
    <div class="px-4 py-3">{{ $applications->links() }}</div>
    @endif
</div>
@endsection
