@extends('layouts.admin')
@section('title', 'Modifier ' . $user->name)
@section('page-title', 'Modifier ' . $user->name)

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="form-card" style="max-width:600px;">
    <h5 class="mb-4" style="color:var(--admin-primary);">Modifier : {{ $user->name }}</h5>

    @if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Nom complet *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Adresse e-mail *</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nouveau mot de passe <span class="text-muted">(laisser vide = inchangé)</span></label>
                <input type="password" name="password" class="form-control" minlength="8">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirmer</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Rôle *</label>
                <select name="role_id" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $user->role_id)==$role->id?'selected':'' }}>
                            {{ $role->label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-admin px-4">
                    <i class="bi bi-save me-1"></i>Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
