@extends('layouts.app')
@section('title', 'Contact')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>{{ __('Contactez-Nous') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Accueil') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Contact') }}</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 5rem 0; background: var(--light);">
    <div class="container">
        <div class="row g-5">
            {{-- Informations contact --}}
            <div class="col-lg-5" data-aos="fade-right">
                <h3 style="color:var(--primary); margin-bottom:2rem;">{{ __('Nos Coordonnées') }}</h3>

                @foreach([
                    ['icon'=>'bi-geo-alt-fill','title'=>__('Adresse'),'content'=>'Avenue Industrielle, Zone Essengue<br>Cameroun, République du cameroun'],
                    ['icon'=>'bi-telephone-fill','title'=>__('Téléphone'),'content'=>'+237 620731930'],
                    ['icon'=>'bi-envelope-fill','title'=>__('Email'),'content'=>'info@mimosaflour.com<br>commercial@mimosaflour.com'],
                    ['icon'=>'bi-clock-fill','title'=>__('Horaires'),'content'=>'Lundi – Vendredi : 7h00 – 17h00<br>Samedi : 8h00 – 15h00'],
                ] as $info)
                    <div class="d-flex gap-4 mb-4">
                        <div style="width:55px; height:55px; background:var(--primary); border-radius:10px;
                                    display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $info['icon'] }}" style="color:var(--secondary); font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 style="color:var(--primary); margin-bottom:.3rem;">{{ $info['title'] }}</h6>
                            <p class="text-muted small mb-0" style="line-height:1.8;">
                                {!! $info['content'] !!}
                            </p>
                        </div>
                    </div>
                @endforeach

                {{-- Carte de géolocalisation --}}
                <div style="border-radius:10px; overflow:hidden; margin-top:2rem; box-shadow:0 4px 25px rgba(0,0,0,.08);">
                    <iframe
                        src="https://www.google.com/maps?q=Zone+Industrielle+Essengue,+Douala,+Cameroun&output=embed"
                        width="100%"
                        height="220"
                        style="border:0; display:block;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation Mimosa Flour - Douala, Zone d'Essengue">
                    </iframe>
                </div>
            </div>

            {{-- Formulaire de contact --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div style="background:#fff; border-radius:10px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,.08);">
                    <h3 style="color:var(--primary); margin-bottom:1.5rem;">{{ __('Envoyez-nous un Message') }}</h3>

                    {{-- Ce formulaire est purement frontend (pas de traitement backend ici) --}}
                    <form>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('Votre Nom *') }}</label>
                                <input type="text" class="form-control" placeholder="Jean Dupont" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('Votre Email *') }}</label>
                                <input type="email" class="form-control" placeholder="ngankouwilfried@mimosaflour.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('Téléphone') }}</label>
                                <input type="tel" class="form-control" placeholder="+237 672518012">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('Sujet *') }}</label>
                                <select class="form-select" required>
                                    <option value="">{{ __('Choisir un sujet') }}</option>
                                    <option>{{ __('Demande de devis') }}</option>
                                    <option>{{ __('Informations produits') }}</option>
                                    <option>{{ __('Partenariat commercial') }}</option>
                                    <option>{{ __('Service après-vente') }}</option>
                                    <option>{{ __('Autre') }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">{{ __('Message *') }}</label>
                                <textarea class="form-control" rows="5"
                                          placeholder="{{ __('Décrivez votre demande...') }}" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3">
                                    <i class="bi bi-send-fill me-2"></i>{{ __('Envoyer le message') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
