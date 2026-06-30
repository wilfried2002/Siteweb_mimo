@extends('layouts.app')
@section('title', $product->name)

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Accueil') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Produits') }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 5rem 0;">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded"
                     style="box-shadow: 0 15px 50px rgba(0,0,0,.15); width:100%;">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span style="color:var(--secondary); font-weight:700; text-transform:uppercase; letter-spacing:2px; font-size:.8rem;">
                    {{ $product->category }}
                </span>
                <h1 style="color:var(--primary); font-size:2.2rem; margin:.5rem 0 1rem;">
                    {{ $product->name }}
                </h1>

                @if($product->weight)
                    <div class="mb-3">
                        <span class="badge" style="background:var(--accent); color:var(--primary); font-size:.85rem; padding:.5rem 1rem;">
                            <i class="bi bi-box me-1"></i> {{ $product->weight }}
                        </span>
                    </div>
                @endif

                @if($product->price)
                    <div class="price mb-4" style="font-size:1.8rem;">
                        {{ number_format($product->price, 0, ',', '.') }} FC
                    </div>
                @endif

                <div style="border-top:1px solid #eee; border-bottom:1px solid #eee; padding:1.5rem 0; margin-bottom:1.5rem;">
                    <p class="text-muted" style="line-height:2; margin:0; white-space:pre-line;">{{ $product->description }}</p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary);"></i>
                            <span class="small">{{ __('Qualité certifiée') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary);"></i>
                            <span class="small">{{ __('100% farine de blé') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary);"></i>
                            <span class="small">{{ __('Sans additifs nocifs') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary);"></i>
                            <span class="small">{{ __('Livraison disponible') }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <button type="button" class="btn btn-primary-custom"
                            onclick="openCartModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price ?? 'null' }})">
                        <i class="bi bi-cart-plus me-2"></i>{{ __('Ajouter au panier') }}
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-custom">
                        <i class="bi bi-cart3 me-2"></i>{{ __('Voir le panier') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>{{ __('Retour') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Produits similaires --}}
        @if($related->count() > 0)
            <div class="mt-6" style="margin-top: 5rem;">
                <div class="section-title">
                    <span class="subtitle">{{ __('De la même gamme') }}</span>
                    <h2>{{ __('Produits Similaires') }}</h2>
                </div>
                <div class="row g-4">
                    @foreach($related as $rel)
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <img src="{{ $rel->image_url }}" class="card-img-top" alt="{{ $rel->name }}">
                                <div class="card-body">
                                    <span class="badge-category">{{ $rel->category }}</span>
                                    <h5 class="card-title mt-2">{{ $rel->name }}</h5>
                                    @if($rel->price)
                                        <div class="price small">{{ number_format($rel->price, 0, ',', '.') }} FC</div>
                                    @endif
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('products.show', $rel) }}"
                                           class="btn btn-outline-secondary btn-sm flex-grow-1">{{ __('Voir') }}</a>
                                        <button type="button" class="btn btn-primary-custom btn-sm flex-grow-1"
                                                onclick="openCartModal({{ $rel->id }}, '{{ addslashes($rel->name) }}', {{ $rel->price ?? 'null' }})">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
