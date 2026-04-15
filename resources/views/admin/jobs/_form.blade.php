{{-- Formulaire partagé offre d'emploi --}}
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Titre du poste *</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $job->title ?? '') }}"
               placeholder="Ex: Ingénieur Qualité Agroalimentaire" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Type de contrat *</label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            @foreach(['CDI','CDD','Stage','Freelance','Temps partiel'] as $type)
                <option value="{{ $type }}"
                    {{ old('type', $job->type ?? 'CDI') === $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Localisation *</label>
        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
               value="{{ old('location', $job->location ?? 'Douala, Cameroun') }}"
               placeholder="Douala, Cameroun" required>
        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date limite *</label>
        <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror"
               value="{{ old('deadline', isset($job) ? $job->deadline->format('Y-m-d') : '') }}"
               min="{{ date('Y-m-d') }}" required>
        @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description du poste *</label>
        <textarea name="description" rows="6"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Décrivez les missions et responsabilités du poste..." required>{{ old('description', $job->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Profil & Exigences</label>
        <textarea name="requirements" rows="5"
                  class="form-control @error('requirements') is-invalid @enderror"
                  placeholder="Diplômes requis, expérience, compétences techniques...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
        @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active"
                   id="is_active" value="1"
                   {{ old('is_active', $job->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Offre active (visible sur le site)
            </label>
        </div>
    </div>
</div>
