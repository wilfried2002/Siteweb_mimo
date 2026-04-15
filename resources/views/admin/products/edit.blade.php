@extends('layouts.admin')
@section('title', 'Modifier Produit')
@section('page-title', 'Modifier le Produit')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <h5 style="color:var(--admin-primary); margin-bottom:1.5rem; border-bottom:2px solid var(--admin-secondary); padding-bottom:.8rem;">
                <i class="bi bi-pencil me-2"></i>Modifier : {{ $product->name }}
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

            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.products._form')
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-admin">
                        <i class="bi bi-save me-2"></i>Mettre à jour
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
