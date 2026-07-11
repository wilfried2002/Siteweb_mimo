@extends('layouts.app')
@section('title', 'Finaliser la commande')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>Finaliser la Commande</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Panier</a></li>
                <li class="breadcrumb-item active">Finaliser</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 4rem 0; background: var(--light);">
    <div class="container">

        {{-- Barre de progression --}}
        <div class="d-flex align-items-center justify-content-center gap-2 mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center gap-2">
                <div style="width:34px; height:34px; background:var(--secondary); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:.85rem;">1</div>
                <span class="small fw-bold">Panier</span>
            </div>
            <div style="width:60px; height:2px; background:var(--secondary);"></div>
            <div class="d-flex align-items-center gap-2">
                <div style="width:34px; height:34px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--secondary); font-weight:800; font-size:.85rem;">2</div>
                <span class="small fw-bold" style="color:var(--primary);">Vos Infos</span>
            </div>
            <div style="width:60px; height:2px; background:#e2e8f0;"></div>
            <div class="d-flex align-items-center gap-2">
                <div style="width:34px; height:34px; background:#e2e8f0; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-weight:800; font-size:.85rem;">3</div>
                <span class="small text-muted">Confirmation</span>
            </div>
        </div>

        <div class="row g-5">
            {{-- ===== FORMULAIRE COORDONNÉES ===== --}}
            <div class="col-lg-7" data-aos="fade-right">
                <div style="background:#fff; border-radius:12px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,.08);">
                    <h4 style="color:var(--primary); margin-bottom:1.8rem;">
                        <i class="bi bi-person-fill me-2 text-gold"></i>
                        Vos Coordonnées
                    </h4>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $e)
                                <div><i class="bi bi-exclamation-triangle me-1"></i>{{ $e }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('orders.store') }}" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nom complet</label>
                                <input type="text" name="customer_name"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       value="{{ old('customer_name') }}"
                                       placeholder="Jean Martin">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">
                                    Numéro de téléphone
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-telephone-fill" style="color:var(--primary);"></i>
                                    </span>
                                    <input type="tel" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="+237 620 731 930"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text text-danger small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Obligatoire — nous vous contacterons pour confirmer votre commande.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Ville</label>
                                <input type="text" name="city"
                                       class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city') }}"
                                       placeholder="Douala">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Adresse de livraison</label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address') }}"
                                       placeholder="Quartier, Rue...">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-2">
                                <div style="background: #fffbeb; border:1px solid #fde68a; border-radius:8px; padding:1rem;">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-info-circle-fill mt-1" style="color:#f59e0b; flex-shrink:0;"></i>
                                        <div class="small">
                                            <strong>Comment ça fonctionne ?</strong><br>
                                            Après validation, notre équipe vous contactera sur le numéro fourni
                                            pour confirmer votre commande et organiser la livraison.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3" style="font-size:1.05rem;">
                                    <i class="bi bi-check2-circle me-2"></i>Confirmer ma commande
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== RÉCAPITULATIF COMMANDE ===== --}}
            <div class="col-lg-5" data-aos="fade-left">
                <div style="background:#fff; border-radius:12px; padding:2rem; box-shadow:0 4px 25px rgba(0,0,0,.08); position:sticky; top:90px;">
                    <h5 style="color:var(--primary); margin-bottom:1.5rem; border-bottom:2px solid var(--secondary); padding-bottom:.8rem;">
                        <i class="bi bi-bag-check me-2 text-gold"></i>Votre Commande
                    </h5>

                    @foreach($items as $item)
                        <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom:1px solid #f8f8f8;">
                            @php
                                $coImg = $item['product_image']
                                    ? (file_exists(public_path('assets/images/'.$item['product_image'])) ? asset('assets/images/'.$item['product_image']) : asset('storage/'.$item['product_image']))
                                    : asset('assets/images/products/premium1kg.jpg');
                            @endphp
                            <img src="{{ $coImg }}"
                                 style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                            <div class="flex-grow-1">
                                <div class="small fw-bold" style="color:var(--primary);">
                                    {{ Str::limit($item['product_name'], 30) }}
                                </div>
                                <div class="small text-muted">Qté : {{ $item['quantity'] }}</div>
                                @if($item['type'] === 'gros')
                                    <span style="font-size:.65rem; background:var(--primary); color:var(--secondary); padding:.15rem .5rem; border-radius:10px; font-weight:700;">GROS</span>
                                @else
                                    <span style="font-size:.65rem; background:var(--accent); color:var(--primary); padding:.15rem .5rem; border-radius:10px; font-weight:700;">DÉTAIL</span>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="small fw-bold" style="color:var(--primary);">
                                    @if($item['type'] === 'gros')
                                        <span class="text-muted">Sur devis</span>
                                    @else
                                        {{ number_format($item['subtotal'], 0, ',', '.') }} FC
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($total > 0)
                        <div class="d-flex justify-content-between mt-3 pt-2">
                            <span class="fw-bold">Total (détail)</span>
                            <span style="font-weight:800; font-size:1.2rem; color:var(--primary); font-family:'Montserrat',sans-serif;">
                                {{ number_format($total, 0, ',', '.') }} FC
                            </span>
                        </div>
                    @endif

                    @php $hasGros = collect($items)->contains('type', 'gros'); @endphp
                    @if($hasGros)
                        <div class="alert alert-secondary small mt-3 mb-0 py-2">
                            <i class="bi bi-telephone me-1"></i>
                            Prix gros communiqués après contact téléphonique.
                        </div>
                    @endif

                    <a href="{{ route('cart.index') }}"
                       class="btn btn-outline-secondary w-100 mt-3" style="font-size:.85rem;">
                        <i class="bi bi-pencil me-2"></i>Modifier le panier
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
