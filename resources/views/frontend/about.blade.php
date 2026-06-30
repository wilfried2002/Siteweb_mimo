@extends('layouts.app')
@section('title', 'À Propos')

@push('styles')
<style>
/* ===== MVV CARDS ===== */
.mvv-card {
    background: #fff;
    padding: 2.5rem;
    border-radius: 12px;
    height: 100%;
    border-top: 4px solid var(--secondary);
    box-shadow: 0 4px 25px rgba(0,0,0,.07);
    transition: transform .35s, box-shadow .35s;
    position: relative;
    overflow: hidden;
}
.mvv-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(200,168,75,.04), transparent 60%);
    opacity: 0;
    transition: opacity .4s;
}
.mvv-card:hover { transform: translateY(-10px); box-shadow: 0 25px 60px rgba(26,58,92,.14); }
.mvv-card:hover::after { opacity: 1; }

.mvv-icon {
    width: 68px; height: 68px;
    background: linear-gradient(135deg, var(--primary), #2a5298);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.5rem;
    animation: floatIcon 4s ease-in-out infinite;
    transition: transform .3s;
}
.mvv-card:hover .mvv-icon { animation: none; transform: scale(1.15) rotate(8deg); }
.mvv-icon i { color: var(--secondary); font-size: 1.6rem; }

@keyframes floatIcon {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-7px); }
}

/* ===== PROCESSUS TIMELINE ===== */
.process-grid { position: relative; }
.process-grid::before {
    content: '';
    position: absolute;
    top: 52px; left: calc(16.66% + 1rem); right: calc(16.66% + 1rem);
    height: 3px;
    background: linear-gradient(90deg, var(--secondary), var(--primary), var(--secondary));
    border-radius: 3px;
    opacity: .25;
}

.process-card {
    background: #fff;
    border-radius: 12px;
    padding: 2rem 1.5rem 1.8rem;
    height: 100%;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    transition: transform .35s, box-shadow .35s, border-color .35s;
    border-bottom: 3px solid transparent;
    position: relative;
    text-align: center;
}
.process-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(26,58,92,.13);
    border-bottom-color: var(--secondary);
}

.process-step-num {
    font-size: 3rem; font-weight: 800;
    color: rgba(200,168,75,.18);
    font-family: 'Montserrat', sans-serif;
    line-height: 1;
    margin-bottom: .4rem;
    transition: color .35s;
}
.process-card:hover .process-step-num { color: rgba(200,168,75,.45); }

.process-icon-wrap {
    width: 54px; height: 54px;
    background: linear-gradient(135deg, var(--secondary), #b8962f);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto .9rem;
    transition: transform .35s;
    box-shadow: 0 4px 15px rgba(200,168,75,.35);
}
.process-card:hover .process-icon-wrap { transform: rotate(360deg) scale(1.1); }
.process-icon-wrap i { color: #fff; font-size: 1.2rem; }

.process-connector {
    display: none;
}
@media (min-width: 992px) {
    .process-connector {
        display: block;
        position: absolute;
        top: 80px; right: -18px;
        width: 36px; height: 3px;
        background: linear-gradient(90deg, var(--secondary), rgba(200,168,75,.2));
        z-index: 1;
    }
}

/* ===== SERVICES CARDS ===== */
.service-enhanced {
    background: #fff;
    border-radius: 12px;
    padding: 2.5rem;
    height: 100%;
    box-shadow: 0 4px 25px rgba(0,0,0,.07);
    border-left: 5px solid transparent;
    transition: transform .35s, box-shadow .35s, border-color .35s;
    position: relative;
    overflow: hidden;
}
.service-enhanced::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 100px; height: 100px;
    border-radius: 50%;
    opacity: .04;
    transition: transform .5s, opacity .4s;
}
.service-enhanced:hover::before { transform: scale(3); opacity: .08; }
.service-enhanced:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 55px rgba(26,58,92,.14);
}

.service-icon-box {
    width: 65px; height: 65px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .4s cubic-bezier(.34,1.56,.64,1);
}
.service-enhanced:hover .service-icon-box { transform: scale(1.15) rotate(-5deg); }

.service-feature-tag {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--light);
    color: var(--primary);
    font-size: .72rem; font-weight: 700;
    padding: .25rem .65rem;
    border-radius: 20px;
    margin: .2rem .15rem 0 0;
    font-family: 'Montserrat', sans-serif;
}
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<section class="breadcrumb-section">
    <div class="container">
        <h1 data-aos="fade-right">{{ __('À Propos de Mimosa') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Accueil') }}</a></li>
                <li class="breadcrumb-item active">{{ __('À Propos') }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Notre Histoire --}}
<section style="padding: 5rem 0;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span style="color:var(--secondary); font-family:'Montserrat',sans-serif; font-weight:600; font-size:.85rem; letter-spacing:3px; text-transform:uppercase;">{{ __('Notre Histoire') }}</span>
                <h2 style="color:var(--primary); margin:1rem 0 1.5rem; font-size:2.2rem;">
                    {{ __('Une Histoire de Passion pour la Qualité') }}
                </h2>
                <p class="text-muted" style="line-height:2;">
                    {{ __('Mimosa est née de la volonté de développer une industrie agroalimentaire forte et compétitive en République du Cameroun. Fondée par un visionnaires, la société s\'est imposée comme une référence incontournable dans la production de farine de blé.') }}
                </p>
                <p class="text-muted" style="line-height:2;">
                    {{ __('Dotée d\'un moulin ultramoderne aux normes européennes, Mimosa transforme quotidiennement des centaines de tonnes de blé importé en farine de haute qualité, contribuant ainsi à la sécurité alimentaire de la population camerounaise.') }}
                </p>
                <p class="text-muted" style="line-height:2;">
                    {{ __('Aujourd\'hui, nos produits sont distribués dans toutes les 10 régions du Cameroun et nous continuons d\'investir dans l\'innovation pour maintenir notre position de leader.') }}
                </p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="{{ asset('images/16d1942a-3411-4f6c-8f5a-c05abc430fb7 (1).jfif') }}"
                     alt="Mimosa Factory"
                     class="img-fluid rounded"
                     style="box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            </div>
        </div>
    </div>
</section>

{{-- Mission Vision Valeurs --}}
<section style="background: var(--light); padding: 5rem 0;">
    <div class="container">
        <div class="section-title" data-aos="fade-up" data-aos-duration="700">
            <span class="subtitle">{{ __('Nos Fondements') }}</span>
            <h2>{{ __('Mission, Vision & Valeurs') }}</h2>
        </div>
        <div class="row g-4">

            {{-- Mission --}}
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="0" data-aos-duration="800">
                <div class="mvv-card">
                    <div class="mvv-icon" style="animation-delay: 0s;">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h4 style="color:var(--primary); margin-bottom:1rem;">{{ __('Notre Mission') }}</h4>
                    <p class="text-muted" style="line-height:1.9; margin:0;">
                        {{ __('Produire et distribuer des farines de blé de qualité supérieure, accessibles à tous, contribuant à l\'alimentation saine des populations camerounaises tout en soutenant le développement économique local.') }}
                    </p>
                </div>
            </div>

            {{-- Vision --}}
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="150" data-aos-duration="800">
                <div class="mvv-card">
                    <div class="mvv-icon" style="animation-delay: .6s;">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h4 style="color:var(--primary); margin-bottom:1rem;">{{ __('Notre Vision') }}</h4>
                    <p class="text-muted" style="line-height:1.9; margin:0;">
                        {{ __('Devenir le leader panafricain de la minoterie, reconnu pour l\'excellence de ses produits, l\'innovation continue et l\'impact positif sur les communautés dans lesquelles nous opérons.') }}
                    </p>
                </div>
            </div>

            {{-- Valeurs --}}
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="300" data-aos-duration="800">
                <div class="mvv-card">
                    <div class="mvv-icon" style="animation-delay: 1.2s;">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h4 style="color:var(--primary); margin-bottom:1rem;">{{ __('Nos Valeurs') }}</h4>
                    <ul class="list-unstyled mb-0" style="line-height:1;">
                        @foreach(['Excellence','Intégrité','Innovation','Responsabilité sociale','Respect de l\'environnement'] as $i => $val)
                            <li data-aos="fade-right" data-aos-delay="{{ 400 + $i * 80 }}" data-aos-duration="400"
                                style="display:flex; align-items:center; gap:.6rem; padding:.45rem 0; border-bottom:1px solid #f0f0f0;">
                                <i class="bi bi-check-circle-fill" style="color:var(--secondary); flex-shrink:0;"></i>
                                <span class="text-muted small fw-bold">{{ __($val) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Chiffres --}}
<section class="stats-section">
    <div class="container">
        <div class="row g-4 text-center">
            @foreach([
                ['n'=>'500+','raw'=>'500+','l'=>__('Tonnes / Jour')],
                ['n'=>'5 000+','raw'=>'5000+','l'=>__('Clients Actifs')],
                ['n'=>'15+','raw'=>'15+','l'=>__('Années d\'Expérience')],
                ['n'=>'200+','raw'=>'200+','l'=>__('Emplois Créés')],
            ] as $idx => $s)
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="{{ $idx * 120 }}" data-aos-duration="600">
                    <div class="stat-item">
                        <div class="number stat-counter" data-target="{{ $s['raw'] }}">{{ $s['n'] }}</div>
                        <div class="label">{{ $s['l'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Processus de production --}}
<section style="padding: 5rem 0; background:#fff;">
    <div class="container">
        <div class="section-title" data-aos="fade-up" data-aos-duration="700">
            <span class="subtitle">{{ __('Comment nous travaillons') }}</span>
            <h2>{{ __('Notre Processus de Production') }}</h2>
        </div>

        <div class="row g-4 process-grid">
            @php
                $steps = [
                    ['step'=>'01','icon'=>'bi-box','title'=>__('Réception du Blé'),
                     'desc'=>__('Sélection rigoureuse du blé à l\'importation, avec contrôle de l\'humidité, de la pureté et des qualités nutritives.')],
                    ['step'=>'02','icon'=>'bi-droplet','title'=>__('Nettoyage & Trempage'),
                     'desc'=>__('Élimination de toutes impuretés. Le blé est lavé et conditionné à l\'humidité optimale pour la mouture.')],
                    ['step'=>'03','icon'=>'bi-gear-wide-connected','title'=>__('Mouture Industrielle'),
                     'desc'=>__('Broyage progressif entre cylindres d\'acier pour obtenir une farine fine, régulière et de haute qualité.')],
                    ['step'=>'04','icon'=>'bi-funnel','title'=>__('Tamisage & Tri'),
                     'desc'=>__('Séparation des différentes fractions : farine blanche, farine bise, semoule et son de blé.')],
                    ['step'=>'05','icon'=>'bi-clipboard-check','title'=>__('Contrôle Qualité'),
                     'desc'=>__('Analyses en laboratoire : taux de cendres, gluten, humidité, granulométrie – avant tout conditionnement.')],
                    ['step'=>'06','icon'=>'bi-bag-check','title'=>__('Conditionnement'),
                     'desc'=>__('Ensachage automatisé en sacs de différents grammages, étiquetés et scellés pour garantir la fraîcheur.')],
                ];
                $aosList = ['zoom-in-up','zoom-in-up','zoom-in-up','zoom-in-down','zoom-in-down','zoom-in-down'];
            @endphp

            @foreach($steps as $idx => $step)
                <div class="col-lg-4 col-md-6 position-relative"
                     data-aos="{{ $aosList[$idx] }}"
                     data-aos-delay="{{ $idx * 100 }}"
                     data-aos-duration="600">

                    <div class="process-card">
                        <div class="process-step-num">{{ $step['step'] }}</div>
                        <div class="process-icon-wrap">
                            <i class="bi {{ $step['icon'] }}"></i>
                        </div>
                        <h5 style="color:var(--primary); margin-bottom:.7rem; font-size:1rem;">{{ $step['title'] }}</h5>
                        <p class="text-muted small mb-0" style="line-height:1.85;">{{ $step['desc'] }}</p>
                    </div>

                    {{-- Connecteur (affiché sauf dernière colonne de chaque ligne) --}}
                    @if(!in_array($idx, [2, 5]))
                        <div class="process-connector"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
// Compteur animé pour les chiffres clés
function animateCounter(el) {
    const target = el.dataset.target;
    const isPlus  = target.includes('+');
    const num     = parseInt(target.replace(/[^0-9]/g, ''));
    const suffix  = target.replace(/[0-9]/g, '').replace('+', isPlus ? '+' : '');
    let start = 0;
    const step  = Math.ceil(num / 60);
    const timer = setInterval(() => {
        start += step;
        if (start >= num) { start = num; clearInterval(timer); }
        el.textContent = (num >= 1000
            ? new Intl.NumberFormat('fr-FR').format(start)
            : start) + (isPlus ? '+' : '');
    }, 25);
}

// Déclenche quand la section stats entre dans la vue
const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            document.querySelectorAll('.stat-counter').forEach(animateCounter);
            observer.disconnect();
        }
    }, { threshold: .4 });
    observer.observe(statsSection);
}
</script>
@endpush

@endsection
