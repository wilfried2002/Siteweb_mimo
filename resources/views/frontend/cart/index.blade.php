@extends('layouts.app')
@section('title', 'Mon Panier')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>Mon Panier</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produits</a></li>
                <li class="breadcrumb-item active">Panier</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 4rem 0; background: var(--light);">
    <div class="container">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                @foreach($errors->all() as $e)
                    <div><i class="bi bi-exclamation-triangle me-2"></i>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        @if(empty($items))
            {{-- ===== PANIER VIDE ===== --}}
            <div class="text-center py-5" data-aos="fade-up">
                <i class="bi bi-cart-x" style="font-size:5rem; color:var(--secondary); display:block; margin-bottom:1.5rem;"></i>
                <h3 style="color:var(--primary);">Votre panier est vide</h3>
                <p class="text-muted mb-4">Découvrez nos produits et ajoutez-les à votre panier.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary-custom">
                    <i class="bi bi-bag me-2"></i>Voir les produits
                </a>
            </div>
        @else
            <div class="row g-4">
                {{-- ===== LISTE DES ARTICLES ===== --}}
                <div class="col-lg-8">
                    <div style="background:#fff; border-radius:12px; box-shadow:0 2px 15px rgba(0,0,0,.07); overflow:hidden;">
                        <div style="padding:1.3rem 1.8rem; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between;">
                            <h5 style="margin:0; color:var(--primary);">
                                <i class="bi bi-cart3 me-2 text-gold"></i>
                                Articles ({{ count($items) }})
                            </h5>
                            <form method="POST" action="{{ route('cart.clear') }}"
                                  onsubmit="return confirm('Vider le panier ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Vider
                                </button>
                            </form>
                        </div>

                        @foreach($items as $item)
                            <div style="padding:1.4rem 1.8rem; border-bottom:1px solid #f8f8f8;"
                                 class="d-flex align-items-center gap-4 flex-wrap">

                                {{-- Image --}}
                                @php
                                    $cartImg = $item['product_image']
                                        ? (file_exists(public_path('assets/images/'.$item['product_image'])) ? asset('assets/images/'.$item['product_image']) : asset('storage/'.$item['product_image']))
                                        : asset('assets/images/products/premium1kg.jpg');
                                @endphp
                                <img src="{{ $cartImg }}"
                                     alt="{{ $item['product_name'] }}"
                                     style="width:70px; height:70px; object-fit:cover; border-radius:10px; flex-shrink:0;">

                                {{-- Infos produit --}}
                                <div class="flex-grow-1">
                                    <div style="font-weight:700; color:var(--primary); font-size:.95rem;">
                                        {{ $item['product_name'] }}
                                    </div>
                                    @if($item['product_weight'])
                                        <div class="small text-muted">{{ $item['product_weight'] }}</div>
                                    @endif
                                    <div class="mt-1">
                                        @if($item['type'] === 'gros')
                                            <span style="background:var(--primary); color:var(--secondary); font-size:.72rem; font-weight:700; padding:.25rem .7rem; border-radius:20px;">
                                                GROS — Prix sur devis
                                            </span>
                                        @else
                                            <span style="background:var(--accent); color:var(--primary); font-size:.72rem; font-weight:600; padding:.25rem .7rem; border-radius:20px;">
                                                DÉTAIL
                                            </span>
                                            @if($item['unit_price'])
                                                <span class="ms-2 small text-muted">
                                                    {{ number_format($item['unit_price'], 0, ',', '.') }} FC / unité
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- Quantité --}}
                                <form method="POST"
                                      action="{{ route('cart.update', urlencode($item['cart_key'])) }}"
                                      class="d-flex align-items-center gap-2">
                                    @csrf @method('PATCH')
                                    <label class="small text-muted fw-bold">Qté</label>
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="{{ $item['type'] === 'gros' ? 100 : 1 }}"
                                           class="form-control form-control-sm text-center"
                                           style="width:80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>

                                {{-- Sous-total --}}
                                <div class="text-end" style="min-width:100px;">
                                    @if($item['type'] === 'gros')
                                        <div style="color:var(--secondary); font-weight:700; font-size:.9rem;">
                                            Sur devis
                                        </div>
                                        <div class="small text-muted">{{ $item['quantity'] }} sacs</div>
                                    @else
                                        <div style="color:var(--primary); font-weight:800; font-size:1.05rem; font-family:'Montserrat',sans-serif;">
                                            {{ number_format($item['subtotal'], 0, ',', '.') }} FC
                                        </div>
                                    @endif
                                </div>

                                {{-- Supprimer --}}
                                <form method="POST"
                                      action="{{ route('cart.remove', urlencode($item['cart_key'])) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Retirer">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                        </a>
                    </div>
                </div>

                {{-- ===== RÉCAPITULATIF ===== --}}
                <div class="col-lg-4">
                    <div style="background:#fff; border-radius:12px; box-shadow:0 2px 15px rgba(0,0,0,.07); padding:1.8rem; position:sticky; top:90px;">
                        <h5 style="color:var(--primary); margin-bottom:1.5rem; border-bottom:2px solid var(--secondary); padding-bottom:.8rem;">
                            <i class="bi bi-receipt me-2 text-gold"></i>Récapitulatif
                        </h5>

                        @foreach($items as $item)
                            <div class="d-flex justify-content-between align-items-start small mb-2">
                                <span class="text-muted" style="max-width:60%;">
                                    {{ Str::limit($item['product_name'], 28) }}
                                    <span class="ms-1 opacity-60">×{{ $item['quantity'] }}</span>
                                </span>
                                <span class="fw-bold">
                                    {{ $item['type'] === 'gros' ? 'Sur devis' : number_format($item['subtotal'], 0, ',', '.') . ' FC' }}
                                </span>
                            </div>
                        @endforeach

                        <hr style="margin: 1rem 0;">

                        @if($total > 0)
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted small">Sous-total (détail)</span>
                                <span style="font-weight:800; color:var(--primary); font-family:'Montserrat',sans-serif; font-size:1.1rem;">
                                    {{ number_format($total, 0, ',', '.') }} FC
                                </span>
                            </div>
                        @endif

                        @php $hasGros = collect($items)->contains('type', 'gros'); @endphp
                        @if($hasGros)
                            <div class="alert alert-info small py-2 mt-2 mb-0" style="border-left:3px solid var(--primary);">
                                <i class="bi bi-info-circle me-1"></i>
                                Le prix des commandes en gros sera communiqué par notre équipe commerciale après validation.
                            </div>
                        @endif

                        <a href="{{ route('orders.checkout') }}"
                           class="btn btn-primary-custom w-100 mt-4">
                            <i class="bi bi-check2-circle me-2"></i>Passer la commande
                        </a>
                        <div class="text-center mt-3 small text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Commande sécurisée — Confirmation par téléphone
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
