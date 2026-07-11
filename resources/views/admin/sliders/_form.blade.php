<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Titre *</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $slider->title ?? '') }}"
               placeholder="Ex: La Qualité au Cœur de Notre Production" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Ordre d'affichage</label>
        <input type="number" name="order" min="0"
               class="form-control @error('order') is-invalid @enderror"
               value="{{ old('order', $slider->order ?? 0) }}">
        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Sous-titre</label>
        <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
               value="{{ old('subtitle', $slider->subtitle ?? '') }}"
               placeholder="Texte secondaire sous le titre principal">
        @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Texte du bouton</label>
        <input type="text" name="button_text" class="form-control"
               value="{{ old('button_text', $slider->button_text ?? '') }}"
               placeholder="Ex: Découvrir nos produits">
    </div>

    <div class="col-md-6">
        <label class="form-label">Lien du bouton</label>
        <input type="text" name="button_link" class="form-control"
               value="{{ old('button_link', $slider->button_link ?? '') }}"
               placeholder="/products">
    </div>

    <div class="col-12">
        <label class="form-label">Image du slider {{ isset($slider) ? '(laisser vide pour conserver)' : '*' }}</label>
        @if(isset($slider))
            <div class="mb-2">
                <img src="{{ $slider->image_url }}"
                     alt="Image actuelle"
                     style="height:100px; border-radius:8px; object-fit:cover;">
                <span class="text-muted small ms-2">Image actuelle</span>
            </div>
        @endif
        <input type="file" name="image" accept="image/*"
               class="form-control @error('image') is-invalid @enderror"
               id="sliderImageInput"
               {{ !isset($slider) ? 'required' : '' }}>
        <div class="form-text">Dimensions recommandées : 1920×900px. JPG, PNG, WebP — max 3 Mo</div>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div id="sliderPreview" class="mt-2"></div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active"
                   id="is_active" value="1"
                   {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Slide active (visible sur le site)</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('sliderImageInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('sliderPreview').innerHTML =
                `<img src="${e.target.result}" style="height:100px; border-radius:8px; object-fit:cover; max-width:300px;">`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
