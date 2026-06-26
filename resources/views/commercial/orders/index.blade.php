@extends('layouts.workspace')
@section('title', 'Commandes — Commercial')
@section('page-title', 'Gestion des Commandes')

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Commercial</li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.commercial.orders.index') }}">
            <i class="bi bi-bag-check"></i> Commandes
            @if($stats['pending'] > 0)
                <span class="badge rounded-pill ms-auto"
                      style="background:var(--ws-secondary);color:#000;font-size:.62rem;">
                    {{ $stats['pending'] }}
                </span>
            @endif
        </a>
    </li>
</ul>
@endsection

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'En attente','value'=>$stats['pending'],'icon'=>'bi-hourglass-split','color'=>'#fef3c7','text'=>'#92400e'],
        ['label'=>'Validées','value'=>$stats['validated'],'icon'=>'bi-check-circle','color'=>'#d1fae5','text'=>'#065f46'],
        ['label'=>'Total','value'=>$stats['total'],'icon'=>'bi-bag','color'=>'#dbeafe','text'=>'#1e40af'],
    ] as $s)
    <div class="col-md-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div style="width:46px;height:46px;border-radius:10px;background:{{ $s['color'] }};
                        display:flex;align-items:center;justify-content:center;">
                <i class="bi {{ $s['icon'] }}" style="color:{{ $s['text'] }};font-size:1.2rem;"></i>
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
        <div class="col-md-4">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Tous les statuts</option>
                @foreach(['pending'=>'En attente','validated'=>'Validées','cancelled'=>'Annulées'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select form-select-sm">
                <option value="">Tous les types</option>
                <option value="detail" {{ request('type')=='detail'?'selected':'' }}>Détail</option>
                <option value="gros" {{ request('type')=='gros'?'selected':'' }}>Gros</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Recherche</label>
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Nom, téléphone…" value="{{ request('search') }}">
        </div>
        <div class="col-md-1">
            <button class="btn btn-ws w-100">OK</button>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="tc-header">
        <h5><i class="bi bi-bag-check me-2"></i>Commandes ({{ $orders->total() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="text-muted small">{{ $order->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $order->customer_name ?? 'N/A' }}</div>
                        <div class="text-muted small">{{ $order->phone }}</div>
                    </td>
                    <td>
                        <span class="badge" style="background:{{ $order->type==='gros'?'#ede9fe':'#f0fdf4' }};
                              color:{{ $order->type==='gros'?'#5b21b6':'#166534' }};">
                            {{ $order->type_label }}
                        </span>
                    </td>
                    <td class="fw-semibold">
                        {{ $order->total ? number_format($order->total, 0, ',', ' ') . ' FCFA' : 'Sur devis' }}
                    </td>
                    <td>
                        <span class="badge rounded-pill" style="{{ $order->status_bg }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('employee.commercial.orders.show', $order) }}"
                               class="btn btn-sm btn-outline-primary py-0 px-2">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('employee.commercial.orders.validate', $order) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success py-0 px-2" title="Valider">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('employee.commercial.orders.reject', $order) }}" class="d-inline"
                                      onsubmit="return confirm('Annuler cette commande ?')">
                                    @csrf
                                    <button class="btn btn-sm btn-danger py-0 px-2" title="Annuler">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune commande trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-4 py-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
