@extends('layouts.workspace')
@section('title', 'Préparation — Magasinier')
@section('page-title', 'Préparation & Expédition')

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Magasinier</li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.magasinier.orders.index') }}">
            <i class="bi bi-boxes"></i> Commandes à traiter
        </a>
    </li>
</ul>
@endsection

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Validées (à préparer)','value'=>$stats['validated'],'color'=>'#dbeafe','text'=>'#1e40af','icon'=>'bi-clipboard-check'],
        ['label'=>'En préparation','value'=>$stats['en_preparation'],'color'=>'#cffafe','text'=>'#155e75','icon'=>'bi-gear'],
        ['label'=>'Expédiées','value'=>$stats['expediee'],'color'=>'#ede9fe','text'=>'#5b21b6','icon'=>'bi-truck'],
        ['label'=>'Livrées','value'=>$stats['livree'],'color'=>'#d1fae5','text'=>'#065f46','icon'=>'bi-house-check'],
    ] as $s)
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:10px;background:{{ $s['color'] }};
                        display:flex;align-items:center;justify-content:center;">
                <i class="bi {{ $s['icon'] }}" style="color:{{ $s['text'] }};font-size:1.1rem;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:var(--ws-primary);">{{ $s['value'] }}</div>
                <div class="text-muted" style="font-size:.72rem;">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filtre --}}
<div class="form-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Tous</option>
                @foreach(['validated'=>'Validées','en_preparation'=>'En préparation','expediee'=>'Expédiées','livree'=>'Livrées'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-ws">Filtrer</button>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="tc-header">
        <h5><i class="bi bi-boxes me-2"></i>Commandes ({{ $orders->total() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Ville</th>
                    <th>Articles</th>
                    <th>Statut</th>
                    <th>Date livraison</th>
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
                    <td class="text-muted small">{{ $order->city ?? '—' }}</td>
                    <td class="text-center">{{ $order->total_quantity }}</td>
                    <td>
                        <span class="badge rounded-pill" style="{{ $order->status_bg }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="text-muted small">
                        {{ $order->delivery_date ? $order->delivery_date->format('d/m/Y') : '—' }}
                    </td>
                    <td>
                        <a href="{{ route('employee.magasinier.orders.show', $order) }}"
                           class="btn btn-sm btn-outline-primary py-0 px-2">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-4 py-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
