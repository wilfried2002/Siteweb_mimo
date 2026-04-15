@extends('layouts.admin')
@section('title', 'Nouveau Produit')
@section('page-title', 'Ajouter un Produit')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <h5 style="color:var(--admin-primary); margin-bottom:1.5rem; border-bottom:2px solid var(--admin-secondary); padding-bottom:.8rem;">
                <i class="bi bi-plus-circle me-2"></i>Nouveau Produit
            </h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.products._form')
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-admin">
                        <i class="bi bi-save me-2"></i>Enregistrer
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-card">
            <h6 style="color:var(--admin-primary); margin-bottom:1rem;">Conseils</h6>
            <ul class="small text-muted list-unstyled">
                <li class="mb-2"><i class="bi bi-info-circle me-2 text-primary"></i>Image recommandée : 800×600px minimum</li>
                <li class="mb-2"><i class="bi bi-info-circle me-2 text-primary"></i>Formats acceptés : JPG, PNG, WebP</li>
                <li class="mb-2"><i class="bi bi-info-circle me-2 text-primary"></i>Taille max : 2 Mo</li>
                <li class="mb-2"><i class="bi bi-info-circle me-2 text-primary"></i>Cochez "En vedette" pour afficher sur la page d'accueil</li>
            </ul>
        </div>
    </div>
</div>
@endsection
