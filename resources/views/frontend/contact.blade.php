@extends('layouts.app')
@section('title', 'Contact')

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>Contactez-Nous</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 5rem 0; background: var(--light);">
    <div class="container">
        <div class="row g-5">
            {{-- Informations contact --}}
            <div class="col-lg-5" data-aos="fade-right">
                <h3 style="color:var(--primary); margin-bottom:2rem;">Nos Coordonnées</h3>

                @foreach([
                    ['icon'=>'bi-geo-alt-fill','title'=>'Adresse','content'=>'Avenue Industrielle, Zone Essengue<br>Cameroun, République du cameroun'],
                    ['icon'=>'bi-telephone-fill','title'=>'Téléphone','content'=>'+237 620731930'],
                    ['icon'=>'bi-envelope-fill','title'=>'Email','content'=>'info@mimosaflour.com<br>commercial@mimosaflour.com'],
                    ['icon'=>'bi-clock-fill','title'=>'Horaires','content'=>'Lundi – Vendredi : 7h00 – 17h00<br>Samedi : 8h00 – 15h00'],
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

                {{-- Carte fictive --}}
                <div style="background:#e8f4f8; border-radius:10px; height:220px; display:flex; align-items:center; justify-content:center; margin-top:2rem;">
                    <div class="text-center text-muted">
                        <i class="bi bi-map" style="font-size:3rem; color:var(--primary);"></i>
                        <p class="mt-2 mb-0 small">DOUALA, Zone d'Essengue</p>
                    </div>
                </div>
            </div>

            {{-- Formulaire de contact --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div style="background:#fff; border-radius:10px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,.08);">
                    <h3 style="color:var(--primary); margin-bottom:1.5rem;">Envoyez-nous un Message</h3>

                    {{-- Ce formulaire est purement frontend (pas de traitement backend ici) --}}
                    <form>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Votre Nom *</label>
                                <input type="text" class="form-control" placeholder="Jean Dupont" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Votre Email *</label>
                                <input type="email" class="form-control" placeholder="jean@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Téléphone</label>
                                <input type="tel" class="form-control" placeholder="+237 672518012">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Sujet *</label>
                                <select class="form-select" required>
                                    <option value="">Choisir un sujet</option>
                                    <option>Demande de devis</option>
                                    <option>Informations produits</option>
                                    <option>Partenariat commercial</option>
                                    <option>Service après-vente</option>
                                    <option>Autre</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Message *</label>
                                <textarea class="form-control" rows="5"
                                          placeholder="Décrivez votre demande..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3">
                                    <i class="bi bi-send-fill me-2"></i>Envoyer le message
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
