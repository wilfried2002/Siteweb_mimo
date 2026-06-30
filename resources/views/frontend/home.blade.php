@extends('layouts.app')
@section('title', 'Accueil')

@section('content')

{{-- ===== CAROUSEL HERO ===== --}}
<section id="hero">
    @if($sliders->count() > 0)
        <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                @foreach($sliders as $i => $slide)
                    <button type="button" data-bs-target="#heroCarousel"
                            data-bs-slide-to="{{ $i }}"
                            class="{{ $i === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliders as $i => $slide)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $slide->image) }}"
                             alt="{{ $slide->title }}"
                             class="d-block w-100">
                        <div class="carousel-caption">
                            <h2 data-aos="fade-right">{{ $slide->title }}</h2>
                            @if($slide->subtitle)
                                <p data-aos="fade-right" data-aos-delay="200">{{ $slide->subtitle }}</p>
                            @endif
                            @if($slide->button_text)
                                <div data-aos="fade-up" data-aos-delay="400">
                                    <a href="{{ $slide->button_link ?? route('products.index') }}"
                                       class="btn btn-primary-custom me-3">
                                        {{ $slide->button_text }}
                                    </a>
                                    <a href="{{ route('about') }}" class="btn btn-outline-custom">
                                        {{ __('En savoir plus') }}
                                    </a>
                                </div>
                            @else
                                <div data-aos="fade-up" data-aos-delay="400">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary-custom me-3">
                                        {{ __('Nos Produits') }}
                                    </a>
                                    <a href="{{ route('contact') }}" class="btn btn-outline-custom">
                                        {{ __('Nous Contacter') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @else
        {{-- Fallback si aucun slider en base --}}
        <div class="hero-carousel position-relative">
            <div style="height:92vh; min-height:500px; overflow:hidden;">
                <img src="{{ asset('images/slider-minoterie-moderne-saker-farine-de-ble-02-copie-3-qq4g6nbocpyf9lys4yjzo0fvoxwg94bbquyjrktbqw.jpg') }}"
                     alt="Mimosa" class="w-100 h-100" style="object-fit:cover; filter:brightness(0.5);">
            </div>
            <div class="carousel-caption" style="bottom:50%; transform:translateY(50%); left:8%; right:8%; text-align:left;">
                <h2 data-aos="fade-right" style="font-size:clamp(2rem,5vw,3.8rem); font-weight:800; text-shadow:2px 2px 8px rgba(0,0,0,.5);">
                    {{ __('La Qualité au Cœur de Notre Production') }}
                </h2>
                <p data-aos="fade-right" data-aos-delay="200" style="font-size:1.2rem; max-width:600px;">
                    {{ __('Mimosa – Leader de la production de farine de blé de qualité supérieure au Cameroun.') }}
                </p>
                <div data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('products.index') }}" class="btn btn-primary-custom me-3">{{ __('Découvrir nos produits') }}</a>
                    <a href="{{ route('about') }}" class="btn btn-outline-custom">{{ __('À propos de nous') }}</a>
                </div>
            </div>
        </div>
    @endif
</section>

{{-- ===== BANDE DE CONFIANCE ===== --}}
<div style="background: var(--secondary); padding: 1.2rem 0;">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <i class="bi bi-award-fill me-2" style="color:var(--dark);"></i>
                <strong style="color:var(--dark); font-size:.9rem;">{{ __('Qualité Certifiée') }}</strong>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-truck me-2" style="color:var(--dark);"></i>
                <strong style="color:var(--dark); font-size:.9rem;">{{ __('Livraison Nationale') }}</strong>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-factory me-2" style="color:var(--dark);"></i>
                <strong style="color:var(--dark); font-size:.9rem;">{{ __('Production Locale') }}</strong>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-shield-check-fill me-2" style="color:var(--dark);"></i>
                <strong style="color:var(--dark); font-size:.9rem;">{{ __('Normes Internationales') }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- ===== À PROPOS (APERÇU) ===== --}}
<section class="py-6" style="padding: 5rem 0; background:#fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ asset('images/bf068541-d51e-4a93-a5b5-b3fc4a2f7b87.jfif') }}"
                         alt="Usine Mimosa"
                         class="img-fluid rounded"
                         style="box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <div class="position-absolute" style="bottom:-30px; right:-20px; background:var(--secondary); padding:1.5rem 2rem; border-radius:6px;">
                        <div style="font-size:2.5rem; font-weight:800; color:var(--dark); font-family:'Montserrat',sans-serif; line-height:1;">15+</div>
                        <div style="font-size:.8rem; color:var(--dark); font-weight:600; text-transform:uppercase; letter-spacing:1px;">{{ __('Ans d\'Expérience') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                <span style="color:var(--secondary); font-family:'Montserrat',sans-serif; font-weight:600; font-size:.85rem; letter-spacing:3px; text-transform:uppercase;">{{ __('À propos de nous') }}</span>
                <h2 class="mt-2 mb-4" style="color:var(--primary); font-size:2.2rem;">
                    {{ __('Excellence et Savoir-faire au Service de la Qualité') }}
                </h2>
                <p class="text-muted" style="line-height:2;">
                    {{ __('Fondée avec la vision de devenir le leader de la minoterie en Afrique centrale, Mimosa produit chaque jour des farines de blé de qualité supérieure destinées aux boulangeries, pâtisseries, ménages et industries agroalimentaires de toute la République du Cameroun.') }}
                </p>
                <p class="text-muted" style="line-height:2;">
                    {{ __('Notre moulin moderne, équipé des dernières technologies européennes, garantit une farine homogène, nutritive et conforme aux normes internationales de sécurité alimentaire.') }}
                </p>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary); font-size:1.2rem;"></i>
                            <span>{{ __('Moulin de haute technologie') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary); font-size:1.2rem;"></i>
                            <span>{{ __('Contrôle qualité rigoureux') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary); font-size:1.2rem;"></i>
                            <span>{{ __('Équipe expérimentée') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--secondary); font-size:1.2rem;"></i>
                            <span>{{ __('Distribution nationale') }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary-custom mt-4">
                    {{ __('En savoir plus') }} <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== CHIFFRES CLÉS ===== --}}
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3" data-aos="fade-up">
                <div class="stat-item">
                    <div class="number">500+</div>
                    <div class="label">{{ __('Tonnes / Jour') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <div class="number">5000+</div>
                    <div class="label">{{ __('Clients Actifs') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <div class="number">15+</div>
                    <div class="label">{{ __('Années d\'Expérience') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <div class="number">26</div>
                    <div class="label">{{ __('Provinces Desservies') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== PRODUITS EN VEDETTE ===== --}}
<section class="py-5 bg-light-custom">
    <div class="container" style="padding-top:2rem; padding-bottom:2rem;">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">{{ __('Notre Gamme') }}</span>
            <h2>{{ __('Nos Produits Phares') }}</h2>
        </div>
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card product-card h-100">
                        <img src="{{ $product->image_url }}"
                             class="card-img-top"
                             alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <span class="badge-category">{{ $product->category }}</span>
                            <h5 class="card-title mt-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                            @if($product->price)
                                <div class="price mt-2">{{ number_format($product->price, 0, ',', '.') }} FC</div>
                            @endif
                            <a href="{{ route('products.show', $product) }}"
                               class="btn btn-primary-custom mt-3 w-100">
                                {{ __('Voir le produit') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Fallback produits statiques --}}
                @foreach([
                    ['name'=>'Farine Premium 1kg','cat'=>'Ménage','img'=>'Prenuim1kg.jpg','desc'=>'Farine de blé ménagère de qualité supérieure, idéale pour la pâtisserie et la cuisine quotidienne.'],
                    ['name'=>'Farine Premium 50kg','cat'=>'Industrie','img'=>'Prenuim50kg.jpg','desc'=>'Sac 50kg pour professionnels : boulangeries, restaurants et revendeurs. Qualité constante garantie.'],
                    ['name'=>'Farine Galimoise','cat'=>'Boulangerie','img'=>'galimoise.jpg','desc'=>'Farine spéciale boulangerie, riche en gluten pour des pains et viennoiseries parfaits.'],
                ] as $idx => $p)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/' . $p['img']) }}"
                                 class="card-img-top" alt="{{ $p['name'] }}">
                            <div class="card-body d-flex flex-column">
                                <span class="badge-category">{{ $p['cat'] }}</span>
                                <h5 class="card-title mt-2">{{ $p['name'] }}</h5>
                                <p class="card-text text-muted small flex-grow-1">{{ $p['desc'] }}</p>
                                <a href="{{ route('products.index') }}"
                                   class="btn btn-primary-custom mt-3 w-100">{{ __('Voir le produit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom">
                {{ __('Voir tous nos produits') }} <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== NOS SERVICES ===== --}}
<section class="py-5" style="padding-top:4rem !important; padding-bottom:4rem !important;">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">{{ __('Ce que nous offrons') }}</span>
            <h2>{{ __('Nos Services') }}</h2>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon'=>'bi-gear-wide-connected','title'=>'Mouture Industrielle','desc'=>'Transformation du blé brut en farine fine grâce à nos équipements de dernière génération, garantissant homogénéité et pureté.'],
                ['icon'=>'bi-shield-check','title'=>'Contrôle Qualité','desc'=>'Chaque lot est soumis à des analyses physicochimiques rigoureuses pour assurer la conformité aux normes alimentaires internationales.'],
                ['icon'=>'bi-truck','title'=>'Distribution & Livraison','desc'=>'Réseau logistique couvrant les 10 regions  avec flotte dédiée pour une livraison rapide et fiable.'],
                ['icon'=>'bi-box-seam','title'=>'Conditionnement','desc'=>'Emballages personnalisés (1kg, 5kg, 25kg, 50kg) avec votre marque pour distributeurs et revendeurs agréés.'],
                ['icon'=>'bi-people','title'=>'Partenariats B2B','desc'=>'Programmes de partenariat adaptés aux boulangeries, pâtisseries, restaurants, hôtels et industries agroalimentaires.'],
                ['icon'=>'bi-headset','title'=>'Support Client','desc'=>'Une équipe dédiée pour répondre à vos questions techniques, commandes spéciales et réclamations.'],
            ] as $idx => $service)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                    <div class="service-card h-100">
                        <div class="icon">
                            <i class="bi {{ $service['icon'] }}"></i>
                        </div>
                        <h5 style="color:var(--primary); margin-bottom:.8rem;">{{ __($service['title']) }}</h5>
                        <p class="text-muted small mb-0">{{ __($service['desc']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== BANDEAU CTA ===== --}}
<section style="background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%); padding: 5rem 0;">
    <div class="container text-center text-white" data-aos="zoom-in">
        <h2 style="font-size:2.2rem; margin-bottom:1rem;">{{ __('Vous cherchez un partenaire de confiance ?') }}</h2>
        <p style="font-size:1.1rem; opacity:.85; max-width:600px; margin: 0 auto 2rem;">
            {{ __('Rejoignez les milliers de clients qui font confiance à Mimosa pour leur approvisionnement en farine de qualité.') }}
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary-custom">
            {{ __('Contactez-nous') }} <i class="bi bi-envelope-fill ms-2"></i>
        </a>
    </div>
</section>

{{-- ===== OFFRES D'EMPLOI ===== --}}
@if($jobs->count() > 0)
<section class="py-5 bg-light-custom" style="padding-top:4rem !important;">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">{{ __('Rejoignez-nous') }}</span>
            <h2>{{ __('Offres d\'Emploi Récentes') }}</h2>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @foreach($jobs as $job)
                    <div class="job-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1" style="color:var(--primary);">{{ $job->title }}</h5>
                                <div class="d-flex align-items-center gap-3 mt-1">
                                    <span><i class="bi bi-geo-alt me-1 text-gold"></i>{{ $job->location }}</span>
                                    <span class="job-type">{{ $job->type }}</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ __('Clôture :') }} {{ $job->deadline->format('d/m/Y') }}
                                </div>
                                <a href="{{ route('careers.show', $job) }}"
                                   class="btn btn-primary-custom" style="padding:.5rem 1.2rem; font-size:.85rem;">
                                    {{ __('Postuler') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center mt-4">
                    <a href="{{ route('careers.index') }}" class="btn btn-primary-custom">
                        {{ __('Toutes les offres') }} <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== RECETTE / INSPIRATION ===== --}}
<section class="py-5" style="padding:4rem 0;">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">{{ __('Inspirations Culinaires') }}</span>
            <h2>{{ __('Faites avec notre Farine') }}</h2>
        </div>
        <div class="row g-4">
            @foreach([
                ['img'=>'Makala.jpg','name'=>'Makala','desc'=>'Beignets traditionnels moelleux et croustillants, à base de farine Mimosa Premium.','desc_key'=>'Beignets traditionnels moelleux et croustillants, à base de farine Mimosa Premium.'],
                ['img'=>'Beignet saker.jpg','name'=>'Beignets Saker','desc'=>'Délicieux beignets frits, légers et savoureux, la recette préférée des ménages camerounais.','desc_key'=>'Délicieux beignets frits, légers et savoureux, la recette préférée des ménages camerounais.'],
                ['img'=>'prenium.jpg','name'=>'Pain Artisanal','desc'=>'Un pain doré à la croûte croustillante, fait avec la farine Mimosa Boulangerie.','desc_key'=>'Un pain doré à la croûte croustillante, fait avec la farine Mimosa Boulangerie.'],
            ] as $idx => $rec)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                    <div class="card border-0 rounded overflow-hidden"
                         style="box-shadow:0 4px 20px rgba(0,0,0,.09);">
                        <div style="height:220px; overflow:hidden;">
                            <img src="{{ asset('images/' . $rec['img']) }}"
                                 alt="{{ $rec['name'] }}"
                                 class="w-100 h-100"
                                 style="object-fit:cover; transition:transform .4s;"
                                 onmouseover="this.style.transform='scale(1.07)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="card-body">
                            <h5 class="text-navy mb-1">{{ $rec['name'] }}</h5>
                            <p class="text-muted small mb-0">{{ __($rec['desc']) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
