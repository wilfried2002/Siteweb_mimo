@extends('layouts.admin')
@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="color:var(--admin-primary);">Employés & Utilisateurs</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-admin">
        <i class="bi bi-person-plus me-1"></i>Ajouter un utilisateur
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:34px;height:34px;background:var(--admin-secondary);border-radius:50%;
                                        display:flex;align-items:center;justify-content:center;font-weight:700;
                                        color:#000;font-size:.85rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @if($user->role)
                            @php
                                $roleColors = ['commercial'=>'#dbeafe::#1e40af','magasinier'=>'#cffafe::#155e75','rh'=>'#f0fdf4::#166534','admin'=>'#fef3c7::#92400e'];
                                [$rb,$rt] = explode('::', $roleColors[$user->role->name] ?? '#f1f5f9::#475569');
                            @endphp
                            <span class="badge rounded-pill" style="background:{{ $rb }};color:{{ $rt }};">
                                {{ $user->role->label }}
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-sm btn-outline-secondary py-0 px-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger py-0 px-2">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-4 py-3">{{ $users->links() }}</div>
    @endif
</div>
@endsection
