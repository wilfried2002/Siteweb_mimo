@extends('layouts.admin')
@section('title', 'Commandes')
@section('page-title', 'Gestion des Commandes')

@section('content')

{{-- Stats --}}
<div class="row g-4 mb-4">
    @foreach([
        ['label'=>'Total commandes','value'=>$stats['total'],'icon'=>'bi-bag-check','color'=>'#1a3a5c','bg'=>'#e8f4f8'],
        ['label'=>'En attente','value'=>$stats['pending'],'icon'=>'bi-clock','color'=>'#f97316','bg'=>'#fff7ed'],
        ['label'=>'Validées','value'=>$stats['validated'],'icon'=>'bi-check-circle','color'=>'#10b981','bg'=>'#d1fae5'],
        ['label'=>'Commandes gros','value'=>$stats['gros'],'icon'=>'bi-boxes','color'=>'#c8a84b','bg'=>'#fef9ec'],
    ] as $s)
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size:.75rem; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; font-weight:600; font-family:'Montserrat',sans-serif;">{{ $s['label'] }}</div>
                        <div style="font-size:2.2rem; font-weight:800; color:var(--admin-primary); font-family:'Montserrat',sans-serif; line-height:1.2; margin-top:.3rem;">{{ $s['value'] }}</div>
                    </div>
                    <div class="icon" style="background:{{ $s['bg'] }};">
                        <i class="bi {{ $s['icon'] }}" style="color:{{ $s['color'] }}; font-size:1.4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Filtres --}}
<div class="table-card mb-4">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Recherche (tél / nom)</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       value="{{ request('search') }}" placeholder="N° téléphone ou nom...">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Statut</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Tous</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
                    <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>Validée</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Type</label>
                <select name="type" class="form-select form-select-sm">
                    <option value="">Tous</option>
                    <option value="detail" {{ request('type') === 'detail' ? 'selected' : '' }}>Détail</option>
                    <option value="gros"   {{ request('type') === 'gros'   ? 'selected' : '' }}>Gros</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-admin btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Filtrer
                </button>
            </div>
            @if(request()->hasAny(['search','status','type']))
                <div class="col-md-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-x me-1"></i>Réinitialiser
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Tableau --}}
<div class="table-card">
    <div class="table-header">
        <h5><i class="bi bi-bag-check me-2" style="color:var(--admin-secondary);"></i>
            Liste des Commandes
            <span class="badge ms-2" style="background:#f1f5f9; color:#64748b; font-size:.72rem;">
                {{ $orders->total() }}
            </span>
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Articles</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <span style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:.8rem; color:#94a3b8;">
                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:.9rem; color:var(--admin-primary);">
                                {{ $order->customer_name ?: '— Sans nom —' }}
                            </div>
                            <div style="font-size:.78rem; color:#94a3b8;">
                                <i class="bi bi-telephone me-1"></i>{{ $order->phone }}
                            </div>
                            @if($order->city)
                                <div style="font-size:.75rem; color:#94a3b8;">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $order->city }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($order->type === 'gros')
                                <span style="background:#1a3a5c; color:#c8a84b; font-size:.72rem; font-weight:700; padding:.3rem .8rem; border-radius:20px;">
                                    GROS
                                </span>
                            @else
                                <span style="background:#e8f4f8; color:#1a3a5c; font-size:.72rem; font-weight:700; padding:.3rem .8rem; border-radius:20px;">
                                    DÉTAIL
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background:#f1f5f9; color:#475569; font-size:.78rem;">
                                {{ $order->items->count() }} produit(s)
                            </span>
                            <div class="small text-muted">{{ $order->total_quantity }} unités</div>
                        </td>
                        <td>
                            @if($order->total)
                                <span style="font-weight:800; font-family:'Montserrat',sans-serif; color:var(--admin-primary);">
                                    {{ number_format($order->total, 0, ',', '.') }} FC
                                </span>
                            @else
                                <span class="small text-muted">Sur devis</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="{{ $order->status_bg }}; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $order->created_at->format('d/m/Y') }}<br><span style="font-size:.72rem;">{{ $order->created_at->format('H:i') }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-primary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.orders.destroy', $order) }}"
                                      onsubmit="return confirm('Supprimer définitivement cette commande ?')">
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
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-bag-x" style="font-size:2.5rem; display:block; margin-bottom:.5rem;"></i>
                            Aucune commande trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid #f0f0f0;">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection
