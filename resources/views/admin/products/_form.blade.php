{{-- Formulaire partagé Créer / Éditer produit --}}
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Nom du produit *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product->name ?? '') }}"
               placeholder="Ex: Farine Premium 1kg" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Poids / Conditionnement</label>
        <input type="text" name="weight" class="form-control @error('weight') is-invalid @enderror"
               value="{{ old('weight', $product->weight ?? '') }}"
               placeholder="Ex: 1 kg, 50 kg">
        @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description *</label>
        <textarea name="description" rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Description détaillée du produit..."
                  required>{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Catégorie *</label>
        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
            @foreach(['farine','boulangerie','pâtisserie','industrie','ménage','semoule','son'] as $cat)
                <option value="{{ $cat }}"
                    {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Prix (FC)</label>
        <input type="number" name="price" step="0.01" min="0"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product->price ?? '') }}"
               placeholder="0">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Image du produit</label>
        @if(isset($product) && $product->image)
            <div class="mb-2">
                <img src="{{ $product->image_url }}"
                     alt="Image actuelle" style="height:80px; border-radius:6px; object-fit:cover;">
                <span class="text-muted small ms-2">Image actuelle</span>
            </div>
        @endif
        <input type="file" name="image" accept="image/*"
               class="form-control @error('image') is-invalid @enderror"
               id="imageInput">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div id="imagePreview" class="mt-2"></div>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="hidden" name="is_featured" value="0">
            <input class="form-check-input" type="checkbox" name="is_featured"
                   id="is_featured" value="1"
                   {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Produit en vedette (page d'accueil)</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="hidden" name="is_active" value="0">
            <input class="form-check-input" type="checkbox" name="is_active"
                   id="is_active" value="1"
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Produit actif (visible sur le site)</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('imageInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML =
                `<img src="${e.target.result}" style="height:100px; border-radius:8px; object-fit:cover;">
                 <span class="text-muted small ms-2">Aperçu</span>`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
