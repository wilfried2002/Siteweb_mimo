@extends('layouts.workspace')
@section('title', 'Commande #' . $order->id)
@section('page-title', 'Commande #' . $order->id)

@section('sidebar-nav')
<ul class="nav flex-column mt-2">
    <li class="nav-section">Commercial</li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('employee.commercial.orders.index') }}">
            <i class="bi bi-bag-check"></i> Commandes
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="{{ route('employee.commercial.orders.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
    <a href="{{ route('employee.commercial.orders.print', $order) }}" target="_blank"
       class="btn btn-sm btn-outline-primary">
        <i class="bi bi-printer me-1"></i>Imprimer — {{ $order->status_label }}
    </a>
</div>

<div class="row g-4">
    {{-- Infos commande --}}
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0" style="color:var(--ws-primary);">
                    <i class="bi bi-bag me-2"></i>Commande #{{ $order->id }}
                </h5>
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
                    <div class="text-muted small fw-bold mb-1">Adresse</div>
                    <div>{{ $order->address ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Type</div>
                    <div>{{ $order->type_label }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small fw-bold mb-1">Date</div>
                    <div>{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                </div>
            </div>

            {{-- Articles --}}
            <h6 style="color:var(--ws-primary);" class="mb-3">Articles commandés</h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th class="text-center">Qté</th>
                            <th class="text-end">P.U.</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? 'Produit supprimé' }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ $item->unit_price ? number_format($item->unit_price, 0, ',', ' ') . ' FCFA' : '—' }}</td>
                            <td class="text-end fw-semibold">{{ $item->total_price ? number_format($item->total_price, 0, ',', ' ') . ' FCFA' : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total commande</th>
                            <th class="text-end" style="color:var(--ws-primary);">
                                {{ $order->total ? number_format($order->total, 0, ',', ' ') . ' FCFA' : 'Sur devis' }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-lg-4">
        {{-- Notes --}}
        <div class="form-card mb-3">
            <h6 style="color:var(--ws-primary);" class="mb-3">Notes internes</h6>
            <form method="POST" action="{{ route('employee.commercial.orders.notes', $order) }}">
                @csrf @method('PATCH')
                <textarea name="notes" class="form-control mb-2" rows="4"
                          placeholder="Notes pour cette commande…">{{ $order->notes }}</textarea>
                <button class="btn btn-ws btn-sm w-100">Enregistrer</button>
            </form>
        </div>

        {{-- Actions statut --}}
        @if($order->status === 'pending')
        <div class="form-card">
            <h6 style="color:var(--ws-primary);" class="mb-3">Actions</h6>
            <form method="POST" action="{{ route('employee.commercial.orders.validate', $order) }}" class="mb-2">
                @csrf
                <button class="btn btn-success w-100">
                    <i class="bi bi-check-lg me-1"></i>Valider la commande
                </button>
            </form>
            <form method="POST" action="{{ route('employee.commercial.orders.reject', $order) }}"
                  onsubmit="return confirm('Annuler cette commande ?')">
                @csrf
                <button class="btn btn-outline-danger w-100">
                    <i class="bi bi-x-lg me-1"></i>Annuler la commande
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
