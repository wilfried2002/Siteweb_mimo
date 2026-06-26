@extends('layouts.workspace')
@section('title', 'Candidature — ' . $application->full_name)
@section('page-title', 'Candidature de ' . $application->full_name)

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Ressources Humaines</li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.rh.applications.index') }}">
            <i class="bi bi-people"></i> Candidatures
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('employee.rh.jobs.index') }}">
            <i class="bi bi-briefcase"></i> Offres d'emploi
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('employee.rh.applications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0" style="color:var(--ws-primary);">
                    <i class="bi bi-person me-2"></i>{{ $application->full_name }}
                </h5>
                @php
                    $colors = ['pending'=>'#fef3c7::#92400e','reviewed'=>'#dbeafe::#1e40af','accepted'=>'#d1fae5::#065f46','rejected'=>'#fee2e2::#991b1b'];
                    [$bg,$tc] = explode('::', $colors[$application->status] ?? '#f1f5f9::#475569');
                @endphp
                <span class="badge rounded-pill px-3 py-2" style="background:{{ $bg }};color:{{ $tc }};font-size:.8rem;">
                    {{ $application->status_label }}
                </span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Email</div>
                    <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Téléphone</div>
                    <div>{{ $application->phone ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Offre / Poste visé</div>
                    <div>
                        @if($application->jobOffer)
                            {{ $application->jobOffer->title }}
                        @elseif($application->desired_position)
                            {{ $application->desired_position }} <span class="text-muted">(spontanée)</span>
                        @else
                            Candidature spontanée
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Date de candidature</div>
                    <div>{{ $application->created_at->format('d/m/Y à H:i') }}</div>
                </div>
            </div>

            {{-- Lettre de motivation --}}
            @if($application->cover_letter)
            <div class="mb-4">
                <div class="text-muted small fw-bold mb-2">Lettre de motivation (texte)</div>
                <div class="p-3 rounded" style="background:#f8fafc;line-height:1.9;font-size:.9rem;">
                    {!! nl2br(e($application->cover_letter)) !!}
                </div>
            </div>
            @endif

            {{-- Téléchargements --}}
            <div class="d-flex flex-wrap gap-2">
                @if($application->cv_path)
                    <a href="{{ route('employee.rh.applications.cv', $application) }}"
                       class="btn btn-ws btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Télécharger le CV
                    </a>
                @endif
                @if($application->lettre_path)
                    <a href="{{ route('employee.rh.applications.lettre', $application) }}"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-earmark-text me-1"></i>Télécharger la lettre
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-lg-4">
        <div class="form-card mb-3">
            <h6 style="color:var(--ws-primary);" class="mb-3">Changer le statut</h6>
            <form method="POST" action="{{ route('employee.rh.applications.status', $application) }}">
                @csrf @method('PATCH')
                <select name="status" class="form-select mb-3">
                    @foreach(['pending'=>'En attente','reviewed'=>'En examen','accepted'=>'Acceptée','rejected'=>'Rejetée'] as $v=>$l)
                        <option value="{{ $v }}" {{ $application->status===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <button class="btn btn-ws w-100">Enregistrer</button>
            </form>
        </div>

        <div class="form-card">
            <h6 style="color:var(--ws-primary);" class="mb-3">Danger</h6>
            <form method="POST" action="{{ route('employee.rh.applications.destroy', $application) }}"
                  onsubmit="return confirm('Supprimer définitivement cette candidature ?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-trash me-1"></i>Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
