@extends('layouts.workspace')
@section('title', 'Commande #' . $order->id)
@section('page-title', 'Commande #' . $order->id)

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Magasinier</li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.magasinier.orders.index') }}">
            <i class="bi bi-boxes"></i> Commandes
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('employee.magasinier.orders.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0" style="color:var(--ws-primary);">Commande #{{ $order->id }}</h5>
                <span class="badge rounded-pill px-3 py-2" style="{{ $order->status_bg }}; font-size:.8rem;">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Client</div>
                    <div>{{ $order->customer_name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Téléphone</div>
                    <div>{{ $order->phone }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Ville</div>
                    <div>{{ $order->city ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Adresse de livraison</div>
                    <div>{{ $order->address ?? 'N/A' }}</div>
                </div>
            </div>

            <h6 style="color:var(--ws-primary);" class="mb-3">Articles</h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th class="text-center">Quantité</th>
                            <th>Conditionnement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? 'Produit supprimé' }}</td>
                            <td class="text-center fw-bold">{{ $item->quantity }}</td>
                            <td class="text-muted small">{{ $item->product?->weight ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($order->notes)
            <div class="mt-3 p-3 rounded" style="background:#f8fafc;">
                <div class="text-muted small fw-bold mb-1">Notes commerciales</div>
                <div class="small">{{ $order->notes }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Mise à jour statut --}}
    <div class="col-lg-4">
        @php
            $nextStatuses = match($order->status) {
                'validated'      => ['en_preparation' => 'Mettre en préparation'],
                'en_preparation' => ['expediee' => 'Marquer Expédiée'],
                'expediee'       => ['livree' => 'Marquer Livrée'],
                default          => [],
            };
        @endphp

        @if(!empty($nextStatuses))
        <div class="form-card">
            <h6 style="color:var(--ws-primary);" class="mb-3">Avancer le statut</h6>
            <form method="POST" action="{{ route('employee.magasinier.orders.status', $order) }}">
                @csrf @method('PATCH')
                @foreach($nextStatuses as $val => $label)
                <input type="hidden" name="status" value="{{ $val }}">
                <div class="mb-3">
                    <label class="form-label">Date de livraison prévue</label>
                    <input type="date" name="delivery_date" class="form-control"
                           value="{{ $order->delivery_date?->format('Y-m-d') }}">
                </div>
                <button class="btn btn-ws w-100">
                    <i class="bi bi-arrow-right-circle me-1"></i>{{ $label }}
                </button>
                @endforeach
            </form>
        </div>
        @else
        <div class="form-card text-center text-muted">
            <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#10b981;"></i>
            <div class="mt-2 fw-semibold">Commande {{ $order->status_label }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
