@extends('layouts.app')
@section('title', $jobOffer->title)

@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <h1>{{ $jobOffer->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('careers.index') }}">Carrières</a></li>
                <li class="breadcrumb-item active">{{ $jobOffer->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<section style="padding: 5rem 0; background: var(--light);">
    <div class="container">
        <div class="row g-5">
            {{-- Détails offre --}}
            <div class="col-lg-7" data-aos="fade-right">
                <div style="background:#fff; border-radius:10px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,.08);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="background:var(--primary); width:55px; height:55px; border-radius:10px;
                                    display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-briefcase" style="color:var(--secondary); font-size:1.5rem;"></i>
                        </div>
                        <div>
                            <h2 style="color:var(--primary); margin:0;">{{ $jobOffer->title }}</h2>
                            <div class="d-flex gap-2 mt-1">
                                <span class="job-type">{{ $jobOffer->type }}</span>
                                <span class="text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $jobOffer->location }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="background:var(--accent); border-radius:8px; padding:1rem 1.5rem; margin-bottom:2rem;">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="small text-muted">Type de contrat</div>
                                <div class="fw-bold text-navy">{{ $jobOffer->type }}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Localisation</div>
                                <div class="fw-bold text-navy">{{ $jobOffer->location }}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Date limite</div>
                                <div class="fw-bold" style="color: {{ $jobOffer->deadline->isPast() ? 'red' : 'var(--primary)' }}">
                                    {{ $jobOffer->deadline->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Publication</div>
                                <div class="fw-bold text-navy">{{ $jobOffer->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <h5 style="color:var(--primary); border-bottom:2px solid var(--secondary); padding-bottom:.5rem; margin-bottom:1rem;">
                        Description du Poste
                    </h5>
                    <div class="text-muted" style="line-height:2;">
                        {!! nl2br(e($jobOffer->description)) !!}
                    </div>

                    @if($jobOffer->requirements)
                        <h5 style="color:var(--primary); border-bottom:2px solid var(--secondary); padding-bottom:.5rem; margin:2rem 0 1rem;">
                            Profil & Exigences
                        </h5>
                        <div class="text-muted" style="line-height:2;">
                            {!! nl2br(e($jobOffer->requirements)) !!}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Formulaire de candidature --}}
            <div class="col-lg-5" data-aos="fade-left">
                <div style="background:#fff; border-radius:10px; padding:2.5rem; box-shadow:0 4px 25px rgba(0,0,0,.08); position:sticky; top:90px;">
                    <h4 style="color:var(--primary); margin-bottom:1.5rem;">
                        <i class="bi bi-send me-2 text-gold"></i>Postuler maintenant
                    </h4>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('careers.apply', $jobOffer) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Prénom *</label>
                                <input type="text" name="first_name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name') }}"
                                       placeholder="Loic" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Nom *</label>
                                <input type="text" name="last_name"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name') }}"
                                       placeholder="Wilfried" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Email *</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="wilfried@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Téléphone</label>
                                <input type="tel" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"
                                       placeholder="+237 672518012">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Lettre de motivation</label>
                                <textarea name="cover_letter" rows="4"
                                          class="form-control @error('cover_letter') is-invalid @enderror"
                                          placeholder="Présentez-vous et expliquez votre motivation...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">CV (PDF uniquement, max 5 Mo) *</label>
                                <input type="file" name="cv"
                                       accept=".pdf"
                                       class="form-control @error('cv') is-invalid @enderror"
                                       required>
                                @error('cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Fichier PDF uniquement, taille maximale 5 Mo.
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">
                                    Lettre de motivation (PDF, facultatif)
                                </label>
                                <input type="file" name="lettre"
                                       accept=".pdf"
                                       class="form-control @error('lettre') is-invalid @enderror">
                                @error('lettre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Fichier PDF uniquement, taille maximale 5 Mo.
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3">
                                    <i class="bi bi-send-fill me-2"></i>Envoyer ma candidature
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-lock me-1"></i>
                            Vos données sont protégées et traitées confidentiellement.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
