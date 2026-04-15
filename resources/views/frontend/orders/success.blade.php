@extends('layouts.app')
@section('title', 'Commande confirmée')

@section('content')

<section style="padding: 5rem 0; background: var(--light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- ===== CONFIRMATION ===== --}}
                <div class="text-center mb-5" data-aos="zoom-in">
                    <div style="width:90px; height:90px; background:linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem;">
                        <i class="bi bi-check-lg" style="font-size:2.5rem; color:#065f46;"></i>
                    </div>
                    <h2 style="color:var(--primary);">Commande enregistrée !</h2>
                    <p class="text-muted" style="font-size:1.1rem; max-width:500px; margin:0 auto;">
                        Merci pour votre commande. Notre équipe vous contactera sous peu au
                        <strong style="color:var(--primary);">{{ $order->phone }}</strong>
                        pour confirmer et organiser la livraison.
                    </p>
                </div>

                {{-- ===== DÉTAILS COMMANDE ===== --}}
                <div style="background:#fff; border-radius:12px; padding:2rem; box-shadow:0 4px 25px rgba(0,0,0,.08);" data-aos="fade-up">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                        <h5 style="color:var(--primary); margin:0;">
                            <i class="bi bi-receipt me-2 text-gold"></i>
                            Commande N° <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </h5>
                        <span style="font-size:.8rem; padding:.4rem 1rem; border-radius:20px;
                                     background:#fef3c7; color:#92400e; font-weight:700;">
                            En attente de confirmation
                        </span>
                    </div>

                    {{-- Infos client --}}
                    <div style="background:#f8fafc; border-radius:8px; padding:1.2rem; margin-bottom:1.5rem;">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="small text-muted">Client</div>
                                <div class="fw-bold" style="color:var(--primary);">
                                    {{ $order->customer_name ?: 'Non renseigné' }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="small text-muted">Téléphone</div>
                                <div class="fw-bold" style="color:var(--primary);">
                                    {{ $order->phone }}
                                </div>
                            </div>
                            @if($order->city)
                            <div class="col-sm-6">
                                <div class="small text-muted">Ville</div>
                                <div class="fw-bold">{{ $order->city }}</div>
                            </div>
                            @endif
                            @if($order->address)
                            <div class="col-sm-6">
                                <div class="small text-muted">Adresse</div>
                                <div class="fw-bold">{{ $order->address }}</div>
                            </div>
                            @endif
                            <div class="col-sm-6">
                                <div class="small text-muted">Type de commande</div>
                                <div class="fw-bold">{{ $order->type_label }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="small text-muted">Date</div>
                                <div class="fw-bold">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Articles --}}
                    <h6 style="color:var(--primary); margin-bottom:1rem;">Articles commandés</h6>
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid #f0f0f0;">
                            <img src="{{ $item->product?->image ? asset('storage/'.$item->product->image) : asset('images/prenium.jpg') }}"
                                 style="width:55px; height:55px; object-fit:cover; border-radius:8px;">
                            <div class="flex-grow-1">
                                <div class="fw-bold small" style="color:var(--primary);">{{ $item->product_name }}</div>
                                <div class="small text-muted">
                                    Quantité : <strong>{{ $item->quantity }}</strong>
                                    @if($item->unit_price)
                                        · {{ number_format($item->unit_price, 0, ',', '.') }} FC/u
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                @if($item->subtotal)
                                    <div class="fw-bold" style="color:var(--primary);">
                                        {{ number_format($item->subtotal, 0, ',', '.') }} FC
                                    </div>
                                @else
                                    <div class="small text-muted">Sur devis</div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if($order->total)
                        <div class="d-flex justify-content-between mt-3 pt-2">
                            <span class="fw-bold">Total</span>
                            <span style="font-weight:800; font-size:1.2rem; color:var(--primary); font-family:'Montserrat',sans-serif;">
                                {{ number_format($order->total, 0, ',', '.') }} FC
                            </span>
                        </div>
                    @endif
                </div>

                {{-- ===== ÉTAPES SUIVANTES ===== --}}
                <div style="background:linear-gradient(135deg, var(--primary), #2a5298); border-radius:12px; padding:2rem; color:#fff; margin-top:2rem; text-align:center;" data-aos="fade-up">
                    <h5 class="mb-3">Que se passe-t-il ensuite ?</h5>
                    <div class="row g-3">
                        @foreach([
                            ['icon'=>'bi-telephone-fill','step'=>'1','text'=>'Notre équipe vous appelle sur votre numéro pour confirmer la commande'],
                            ['icon'=>'bi-calendar-check','step'=>'2','text'=>'Nous planifions ensemble la date et le lieu de livraison'],
                            ['icon'=>'bi-truck','step'=>'3','text'=>'Vos produits sont livrés à l\'adresse convenue'],
                        ] as $step)
                        <div class="col-md-4">
                            <div style="background:rgba(255,255,255,.1); border-radius:10px; padding:1.2rem;">
                                <div style="width:40px; height:40px; background:var(--secondary); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto .8rem; font-weight:800; color:var(--dark);">
                                    {{ $step['step'] }}
                                </div>
                                <p class="small mb-0" style="opacity:.9;">{{ $step['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-4 d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('home') }}" class="btn btn-primary-custom">
                        <i class="bi bi-house me-2"></i>Retour à l'accueil
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-bag me-2"></i>Continuer mes achats
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
