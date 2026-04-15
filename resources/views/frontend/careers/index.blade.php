@extends('layouts.app')
@section('title', 'Carrières')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>Carrières chez Mimosa Flour</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Carrières</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Intro --}}
<section style="padding: 4rem 0; background:#fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span style="color:var(--secondary); font-family:'Montserrat',sans-serif; font-weight:600; font-size:.85rem; letter-spacing:3px; text-transform:uppercase;">Rejoignez notre équipe</span>
                <h2 style="color:var(--primary); margin:1rem 0 1.5rem; font-size:2.2rem;">
                    Construisez Votre Avenir<br>avec Mimosa Flour
                </h2>
                <p class="text-muted" style="line-height:2;">
                    Chez Mimosa Flour, nous croyons que nos collaborateurs sont notre plus grande richesse.
                    Rejoindre notre équipe, c'est intégrer une entreprise dynamique, tournée vers l'innovation
                    et profondément engagée dans le développement du Cameroun.
                </p>
                <div class="row g-3 mt-2">
                    @foreach([
                        ['icon'=>'bi-graph-up-arrow','text'=>'Évolution de carrière'],
                        ['icon'=>'bi-heart','text'=>'Environnement bienveillant'],
                        ['icon'=>'bi-mortarboard','text'=>'Formation continue'],
                        ['icon'=>'bi-cash-coin','text'=>'Rémunération compétitive'],
                    ] as $avantage)
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $avantage['icon'] }}" style="color:var(--secondary); font-size:1.1rem;"></i>
                                <span class="small">{{ $avantage['text'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="{{ asset('images/bf068541-d51e-4a93-a5b5-b3fc4a2f7b87.jfif') }}"
                     alt="Travailler chez Mimosa Flour"
                     class="img-fluid rounded"
                     style="box-shadow: 0 15px 50px rgba(0,0,0,.12);">
            </div>
        </div>
    </div>
</section>

{{-- Offres d'emploi --}}
<section style="padding: 4rem 0; background: var(--light);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <span class="subtitle">Postes ouverts</span>
            <h2>Offres d'Emploi Disponibles</h2>
        </div>

        @if($jobs->count() > 0)
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    @foreach($jobs as $job)
                        <div class="job-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div class="flex-grow-1">
                                    <h4 style="color:var(--primary); margin-bottom:.5rem;">{{ $job->title }}</h4>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                        <span class="job-type">{{ $job->type }}</span>
                                        <span class="text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $job->location }}
                                        </span>
                                        <span class="text-muted small">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Clôture : {{ $job->deadline->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        {{ Str::limit($job->description, 180) }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('careers.show', $job) }}"
                                       class="btn btn-primary-custom">
                                        Voir & Postuler <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <div style="background:#fff; padding:3rem; border-radius:10px; box-shadow:0 3px 20px rgba(0,0,0,.07);">
                    <i class="bi bi-briefcase" style="font-size:3rem; color:var(--secondary); display:block; margin-bottom:1rem;"></i>
                    <h4 style="color:var(--primary);">Aucune offre disponible pour le moment</h4>
                    <p class="text-muted mb-4">
                        Nous n'avons pas d'offre d'emploi ouverte actuellement, mais nous recevons toujours
                        les candidatures spontanées.
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom">
                        Envoyer une candidature spontanée
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
