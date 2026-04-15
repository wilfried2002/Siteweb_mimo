@extends('layouts.admin')
@section('title', 'Commande #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))
@section('page-title', 'Détail de la Commande')

@section('content')

<div class="row g-4">
    {{-- ===== COLONNE GAUCHE — Détails ===== --}}
    <div class="col-lg-8">

        {{-- Entête --}}
        <div class="form-card mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h4 style="color:var(--admin-primary); margin:0;">
                        Commande
                        <span style="color:var(--admin-secondary);">
                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </h4>
                    <div class="small text-muted mt-1">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $order->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    @if($order->type === 'gros')
                        <span style="background:#1a3a5c; color:#c8a84b; font-size:.8rem; font-weight:700; padding:.4rem 1rem; border-radius:20px;">
                            COMMANDE EN GROS
                        </span>
                    @else
                        <span style="background:#e8f4f8; color:#1a3a5c; font-size:.8rem; font-weight:700; padding:.4rem 1rem; border-radius:20px;">
                            COMMANDE EN DÉTAIL
                        </span>
                    @endif
                    <span class="badge" style="{{ $order->status_bg }}; font-size:.78rem; padding:.4rem 1rem; border-radius:20px;">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            {{-- Infos client --}}
            <div style="background:#f8fafc; border-radius:10px; padding:1.3rem; margin-bottom:1.5rem;">
                <h6 style="color:var(--admin-primary); margin-bottom:1rem;">
                    <i class="bi bi-person-fill me-2" style="color:var(--admin-secondary);"></i>
                    Informations Client
                </h6>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="small text-muted">Nom</div>
                        <div class="fw-bold">{{ $order->customer_name ?: '— Non renseigné —' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Téléphone</div>
                        <div class="fw-bold">
                            <a href="tel:{{ $order->phone }}" style="color:var(--admin-primary);">
                                <i class="bi bi-telephone-fill me-1" style="color:var(--admin-secondary);"></i>
                                {{ $order->phone }}
                            </a>
                        </div>
                    </div>
                    @if($order->city)
                        <div class="col-sm-6">
                            <div class="small text-muted">Ville</div>
                            <div class="fw-bold">{{ $order->city }}</div>
                        </div>
                    @endif
                    @if($order->address)
                        <div class="col-sm-12">
                            <div class="small text-muted">Adresse de livraison</div>
                            <div class="fw-bold">{{ $order->address }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Articles commandés --}}
            <h6 style="color:var(--admin-primary); margin-bottom:1rem;">
                <i class="bi bi-bag me-2" style="color:var(--admin-secondary);"></i>
                Articles Commandés
            </h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th>Produit</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-end">Prix unitaire</th>
                            <th class="text-end">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item->product?->image ? asset('storage/'.$item->product->image) : asset('images/prenium.jpg') }}"
                                             style="width:42px; height:42px; object-fit:cover; border-radius:6px;">
                                        <div>
                                            <div class="small fw-bold">{{ $item->product_name }}</div>
                                            @if($item->product?->weight)
                                                <div style="font-size:.72rem; color:#94a3b8;">{{ $item->product->weight }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                <td class="text-end small">
                                    {{ $item->unit_price ? number_format($item->unit_price, 0, ',', '.') . ' FC' : 'Sur devis' }}
                                </td>
                                <td class="text-end fw-bold">
                                    {{ $item->subtotal ? number_format($item->subtotal, 0, ',', '.') . ' FC' : 'Sur devis' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#f8fafc;">
                            <td colspan="3" class="text-end fw-bold" style="color:var(--admin-primary);">TOTAL</td>
                            <td class="text-end" style="font-weight:800; font-size:1.05rem; color:var(--admin-primary); font-family:'Montserrat',sans-serif;">
                                {{ $order->total ? number_format($order->total, 0, ',', '.') . ' FC' : 'Sur devis' }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->type === 'gros')
                <div class="alert alert-warning small mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Commande en gros : le prix définitif doit être communiqué au client par téléphone.
                </div>
            @endif
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    {{-- ===== COLONNE DROITE — Actions ===== --}}
    <div class="col-lg-4">

        {{-- Changer le statut --}}
        <div class="form-card mb-4">
            <h6 style="color:var(--admin-primary); margin-bottom:1.2rem;">
                <i class="bi bi-arrow-repeat me-2" style="color:var(--admin-secondary);"></i>
                Mettre à jour le statut
            </h6>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="form-label small fw-bold">Statut actuel</label>
                    <select name="status" class="form-select" required>
                        <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="validated" {{ $order->status === 'validated' ? 'selected' : '' }}>✅ Validée</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Annulée</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-admin w-100">
                    <i class="bi bi-save me-2"></i>Enregistrer le statut
                </button>
            </form>

            <hr style="margin:1.5rem 0;">

            {{-- Statuts colorés --}}
            <div style="background:#f8fafc; border-radius:8px; padding:1rem;">
                <div class="small fw-bold mb-2" style="color:var(--admin-primary);">Légende</div>
                <div class="d-flex flex-column gap-2">
                    <div><span class="badge" style="background:#fef3c7;color:#92400e; border-radius:20px; font-size:.72rem; padding:.3rem .7rem;">En attente</span> — Commande non traitée</div>
                    <div><span class="badge" style="background:#d1fae5;color:#065f46; border-radius:20px; font-size:.72rem; padding:.3rem .7rem;">Validée</span> — Livraison confirmée</div>
                    <div><span class="badge" style="background:#fee2e2;color:#991b1b; border-radius:20px; font-size:.72rem; padding:.3rem .7rem;">Annulée</span> — Commande annulée</div>
                </div>
            </div>
        </div>

        {{-- Notes admin --}}
        <div class="form-card mb-4">
            <h6 style="color:var(--admin-primary); margin-bottom:1.2rem;">
                <i class="bi bi-sticky me-2" style="color:var(--admin-secondary);"></i>
                Notes internes
            </h6>
            <form method="POST" action="{{ route('admin.orders.notes', $order) }}">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <textarea name="notes" class="form-control" rows="4"
                              placeholder="Ajoutez des notes sur cette commande (prix gros, délai, accord client...)">{{ $order->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-admin w-100">
                    <i class="bi bi-save me-2"></i>Sauvegarder la note
                </button>
            </form>
        </div>

        {{-- Appel direct --}}
        <div class="form-card mb-4" style="background:linear-gradient(135deg, var(--admin-primary), #2a5298); color:#fff;">
            <h6 class="mb-3" style="color:var(--admin-secondary);">
                <i class="bi bi-telephone-fill me-2"></i>Contact Client
            </h6>
            <div style="font-size:1.4rem; font-weight:800; font-family:'Montserrat',sans-serif; color:#fff; margin-bottom:.5rem;">
                {{ $order->phone }}
            </div>
            <div class="small mb-3" style="opacity:.75;">
                {{ $order->customer_name ?: 'Nom non renseigné' }}
            </div>
            <a href="tel:{{ $order->phone }}" class="btn btn-sm w-100"
               style="background:var(--admin-secondary); color:#000; font-weight:700;">
                <i class="bi bi-telephone-fill me-2"></i>Appeler maintenant
            </a>
        </div>

        {{-- Supprimer --}}
        <form method="POST"
              action="{{ route('admin.orders.destroy', $order) }}"
              onsubmit="return confirm('Supprimer définitivement cette commande ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="bi bi-trash me-2"></i>Supprimer la commande
            </button>
        </form>
    </div>
</div>

@endsection
