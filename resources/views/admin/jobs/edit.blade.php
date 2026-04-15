@extends('layouts.admin')
@section('title', "Modifier Offre")
@section('page-title', "Modifier l'Offre d'Emploi")

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="form-card">
            <h5 style="color:var(--admin-primary); margin-bottom:1.5rem; border-bottom:2px solid var(--admin-secondary); padding-bottom:.8rem;">
                <i class="bi bi-pencil me-2"></i>Modifier : {{ $job->title }}
            </h5>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.jobs.update', $job) }}">
                @csrf @method('PUT')
                @include('admin.jobs._form')
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-admin">
                        <i class="bi bi-save me-2"></i>Mettre à jour
                    </button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
