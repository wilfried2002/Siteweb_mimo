@extends('layouts.app')
@section('title', 'Nos Services')

@push('styles')
<style>
.service-card-pro {
    background: #fff;
    border-radius: 14px;
    padding: 2.5rem;
    height: 100%;
    box-shadow: 0 4px 25px rgba(0,0,0,.07);
    transition: transform .35s, box-shadow .35s;
    position: relative;
    overflow: hidden;
}
.service-card-pro::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--secondary), #b8962f);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .4s ease;
}
.service-card-pro:hover { transform: translateY(-10px); box-shadow: 0 28px 65px rgba(26,58,92,.14); }
.service-card-pro:hover::before { transform: scaleX(1); }

.service-icon-pro {
    width: 68px; height: 68px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .4s cubic-bezier(.34,1.56,.64,1), box-shadow .35s;
}
.service-card-pro:hover .service-icon-pro {
    transform: scale(1.15) rotate(-6deg);
    box-shadow: 0 8px 25px rgba(0,0,0,.2);
}
.service-icon-pro i { font-size: 1.7rem; }

.service-badge {
    display: inline-block;
    background: var(--light);
    color: var(--primary);
    font-size: .7rem; font-weight: 700;
    padding: .22rem .65rem;
    border-radius: 20px;
    margin: .25rem .15rem 0 0;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: .3px;
    transition: background .25s, color .25s;
}
.service-card-pro:hover .service-badge { background: rgba(200,168,75,.15); color: #7a6020; }

.service-title-line {
    width: 0; height: 2px;
    background: var(--secondary);
    margin: .6rem 0 1rem;
    transition: width .5s ease;
    border-radius: 2px;
}
.service-card-pro:hover .service-title-line { width: 40px; }
</style>
@endpush

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>Nos Services</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 5rem 0;">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">Ce que nous proposons</span>
            <h2>Nos Services Professionnels</h2>
        </div>
        @php
            $services = [
                ['icon'=>'bi-gear-wide-connected','color'=>'#1a3a5c','bg'=>'rgba(26,58,92,.9)',
                 'aos'=>'fade-right',
                 'title'=>'Production de Farine',
                 'desc'=>'Notre moulin industriel de pointe produit chaque jour plusieurs centaines de tonnes de farine de blé de différents types : T55, T65, farine complète, semoule fine et grossière. Chaque produit est fabriqué selon des procédés maîtrisés.',
                 'features'=>['Capacité : 500+ T/jour','Équipements suisses et allemands','Farine blanche, complète, semoule']],
                ['icon'=>'bi-shield-check','color'=>'#c8a84b','bg'=>'rgba(200,168,75,.85)',
                 'aos'=>'fade-left',
                 'title'=>'Contrôle Qualité & Lab',
                 'desc'=>'Notre laboratoire interne réalise des analyses continues tout au long du processus. Chaque lot est testé sur les paramètres critiques : humidité, cendres, gluten, granulométrie et absence de contaminants.',
                 'features'=>['Analyses physicochimiques','Traçabilité totale des lots','Certification aux normes ISO']],
                ['icon'=>'bi-truck','color'=>'#1a3a5c','bg'=>'rgba(26,58,92,.9)',
                 'aos'=>'fade-right',
                 'title'=>'Distribution & Logistique',
                 'desc'=>'Grâce à notre flotte dédiée et notre réseau de distributeurs agréés, nous livrons partout au Cameroun et dans les pays voisins. Aucune région n\'est trop éloignée pour notre réseau logistique.',
                 'features'=>['Livraison dans les 10 régions du Cameroun','Flotte réfrigérée disponible','Suivi en temps réel']],
                ['icon'=>'bi-box-seam','color'=>'#c8a84b','bg'=>'rgba(200,168,75,.85)',
                 'aos'=>'fade-left',
                 'title'=>'Conditionnement Personnalisé',
                 'desc'=>'Service d\'emballage sur mesure pour distributeurs et marques partenaires. Vos sacs à vos couleurs et formats, de 500g à 50 kg — idéal pour grandes surfaces, grossistes et marques distributeur.',
                 'features'=>['Formats : 500g à 50 kg','Impression marque blanche','Délai rapide de production']],
                ['icon'=>'bi-people','color'=>'#1a3a5c','bg'=>'rgba(26,58,92,.9)',
                 'aos'=>'fade-right',
                 'title'=>'Partenariats B2B',
                 'desc'=>'Nous accompagnons entrepreneurs et entreprises alimentaires avec des conditions avantageuses, un approvisionnement régulier et un support technique. Boulangers, pâtissiers, restaurateurs — rejoignez notre réseau.',
                 'features'=>['Contrats de fourniture long terme','Tarifs dégressifs sur volume','Conseiller commercial dédié']],
                ['icon'=>'bi-mortarboard','color'=>'#c8a84b','bg'=>'rgba(200,168,75,.85)',
                 'aos'=>'fade-left',
                 'title'=>'Formation & Conseil',
                 'desc'=>'Nos ingénieurs agroalimentaires proposent des formations pratiques sur l\'utilisation optimale de nos farines : panification, dosages, conservation et amélioration des recettes pour des résultats d\'excellence.',
                 'features'=>['Formations en boulangerie','Conseils en formulation','Fiches techniques produits']],
            ];
        @endphp

        <div class="row g-4">
            @foreach($services as $idx => $service)
                <div class="col-lg-6"
                     data-aos="{{ $service['aos'] }}"
                     data-aos-delay="{{ intdiv($idx, 2) * 120 }}"
                     data-aos-duration="650">
                    <div class="service-card-pro">
                        <div class="d-flex align-items-start gap-4">
                            <div class="service-icon-pro"
                                 style="background:{{ $service['bg'] }}; box-shadow:0 6px 20px rgba(0,0,0,.18);">
                                <i class="bi {{ $service['icon'] }}"
                                   style="color:{{ $service['color'] === '#c8a84b' ? '#fff' : 'var(--secondary)' }};"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 style="color:var(--primary); margin-bottom:0;">{{ $service['title'] }}</h4>
                                <div class="service-title-line"></div>
                                <p class="text-muted small mb-3" style="line-height:1.9;">{{ $service['desc'] }}</p>
                                <div>
                                    @foreach($service['features'] as $f)
                                        <span class="service-badge">
                                            <i class="bi bi-check2" style="color:var(--secondary); margin-right:.25rem;"></i>{{ $f }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="background:linear-gradient(135deg, var(--primary) 0%, #2a5298 100%); padding:4rem 0;">
    <div class="container text-center text-white" data-aos="zoom-in">
        <h3 class="mb-3">Prêt à démarrer un partenariat ?</h3>
        <p class="mb-4" style="opacity:.85;">Notre équipe commerciale est disponible pour étudier votre projet.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary-custom">
            Contactez-nous <i class="bi bi-envelope-fill ms-2"></i>
        </a>
    </div>
</section>

@endsection
