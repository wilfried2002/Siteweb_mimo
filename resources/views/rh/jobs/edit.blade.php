@extends('layouts.workspace')
@section('title', "Modifier l'offre — RH")
@section('page-title', "Modifier l'offre")

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Ressources Humaines</li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('employee.rh.applications.index') }}">
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
<div class="mb-3">
    <a href="{{ route('employee.rh.jobs.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="form-card" style="max-width:700px;">
    <h5 class="mb-4" style="color:var(--ws-primary);">Modifier : {{ $job->title }}</h5>

    @if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('employee.rh.jobs.update', $job) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Titre du poste *</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $job->title) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Type de contrat *</label>
                <select name="type" class="form-select" required>
                    @foreach(['CDI','CDD','Stage','Intérim','Temps partiel'] as $t)
                        <option value="{{ $t }}" {{ old('type', $job->type)===$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Localisation *</label>
                <input type="text" name="location" class="form-control"
                       value="{{ old('location', $job->location) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de clôture *</label>
                <input type="date" name="deadline" class="form-control"
                       value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                           {{ old('is_active', $job->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">Offre active</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" rows="8"
                          required>{{ old('description', $job->description) }}</textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-ws px-4">
                    <i class="bi bi-save me-1"></i>Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
