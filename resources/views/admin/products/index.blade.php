@extends('layouts.admin')
@section('title', 'Produits')
@section('page-title', 'Gestion des Produits')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h5><i class="bi bi-bag me-2" style="color:var(--admin-secondary);"></i>Liste des Produits</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-admin">
            <i class="bi bi-plus-circle me-2"></i>Nouveau produit
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Poids</th>
                    <th>Prix</th>
                    <th>En vedette</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="small text-muted">{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}"
                                     style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                                <div>
                                    <div style="font-weight:600; font-size:.9rem;">{{ $product->name }}</div>
                                    <div style="font-size:.75rem; color:#94a3b8;">
                                        {{ Str::limit($product->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $product->category }}</span></td>
                        <td class="small">{{ $product->weight ?? '—' }}</td>
                        <td class="small">
                            {{ $product->price ? number_format($product->price, 0, ',', '.') . ' FC' : '—' }}
                        </td>
                        <td>
                            @if($product->is_featured)
                                <span class="badge" style="background:#fef3c7; color:#92400e;">
                                    <i class="bi bi-star-fill me-1"></i>Oui
                                </span>
                            @else
                                <span class="text-muted small">Non</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge" style="background:#d1fae5; color:#065f46; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Actif</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2.5rem; display:block; margin-bottom:.5rem;"></i>
                            Aucun produit enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid #f0f0f0;">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
