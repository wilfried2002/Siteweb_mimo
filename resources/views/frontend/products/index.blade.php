@extends('layouts.app')
@section('title', 'Nos Produits')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>{{ __('Nos Produits') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Accueil') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Produits') }}</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 4rem 0; background: var(--light);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">{{ __('Notre gamme complète') }}</span>
            <h2>{{ __('Tous Nos Produits') }}</h2>
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="card product-card h-100">
                            <img src="{{ $product->image_url }}"
                                 class="card-img-top"
                                 alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <span class="badge-category">{{ $product->category }}</span>
                                @if($product->weight)
                                    <span class="badge bg-light text-dark ms-2"
                                          style="font-size:.72rem;">{{ $product->weight }}</span>
                                @endif
                                <h5 class="card-title mt-2">{{ $product->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 120) }}
                                </p>
                                @if($product->price)
                                    <div class="price mt-2">
                                        {{ number_format($product->price, 0, ',', '.') }} FC
                                    </div>
                                @endif
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-outline-secondary flex-grow-1" style="font-size:.82rem;">
                                        {{ __('Détail') }} <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-primary-custom flex-grow-1"
                                            style="font-size:.82rem;"
                                            onclick="openCartModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price ?? 'null' }})">
                                        <i class="bi bi-cart-plus me-1"></i>{{ __('Commander') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            {{-- Produits statiques fallback --}}
            <div class="row g-4">
                @foreach([
                    ['name'=>'Farine Premium 1kg','cat'=>'Ménage','weight'=>'1 kg','img'=>'Prenuim1kg.jpg','desc'=>'Farine de blé ménagère de qualité supérieure, idéale pour la pâtisserie, les gâteaux, beignets et la cuisine du quotidien. Texture fine et blanche, riche en gluten naturel.'],
                    ['name'=>'Farine Premium 50kg','cat'=>'Industrie','weight'=>'50 kg','img'=>'Prenuim50kg.jpg','desc'=>'Sac professionnel 50 kg destiné aux boulangeries, hôtels, restaurants et revendeurs en gros. Qualité constante, livraison rapide dans tout le Cameroun.'],
                    ['name'=>'Farine Galimoise','cat'=>'Boulangerie','weight'=>'25 kg','img'=>'galimoise.jpg','desc'=>'Farine spéciale boulangerie, à haute teneur en gluten pour des pains croustillants, baguettes et viennoiseries. La préférée des boulangers professionnels.'],
                    ['name'=>'Farine Makala','cat'=>'Friture','weight'=>'1 kg','img'=>'Makala.jpg','desc'=>'Farine spécialement sélectionnée pour la friture. Donne des makala et beignets légers, moelleux et croustillants, sans grumeaux.'],
                    ['name'=>'Farine Beignets Saker','cat'=>'Pâtisserie','weight'=>'500 g','img'=>'Beignet saker.jpg','desc'=>'Mélange prêt-à-l\'emploi pour beignets traditionnels camerounais. Résultats parfaits à chaque fois, même pour les débutants.'],
                    ['name'=>'Farine Premium Standard','cat'=>'Polyvalente','weight'=>'5 kg','img'=>'prenium.jpg','desc'=>'Farine tout usage, idéale pour un usage quotidien : sauces, soupes, fritures et pâtisseries légères. Format économique pour les familles.'],
                ] as $idx => $p)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 100 }}">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/' . $p['img']) }}"
                                 class="card-img-top" alt="{{ $p['name'] }}">
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <span class="badge-category">{{ $p['cat'] }}</span>
                                    <span class="badge bg-light text-dark ms-2"
                                          style="font-size:.72rem;">{{ $p['weight'] }}</span>
                                </div>
                                <h5 class="card-title mt-2">{{ $p['name'] }}</h5>
                                <p class="card-text text-muted small flex-grow-1">{{ $p['desc'] }}</p>
                                <a href="{{ route('contact') }}"
                                   class="btn btn-primary-custom mt-3 w-100">{{ __('Commander') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- CTA commander --}}
<section style="background: var(--primary); padding: 4rem 0;">
    <div class="container text-center text-white" data-aos="fade-up">
        <h3 class="mb-3">{{ __('Intéressé par nos produits en gros ?') }}</h3>
        <p class="mb-4" style="opacity:.85;">
            {{ __('Contactez notre équipe commerciale pour obtenir un devis personnalisé et des conditions avantageuses.') }}
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary-custom">
            {{ __('Demander un devis') }} <i class="bi bi-send ms-2"></i>
        </a>
    </div>
</section>

@endsection
