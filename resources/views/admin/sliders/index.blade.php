@extends('layouts.admin')
@section('title', 'Sliders')
@section('page-title', 'Gestion du Carousel')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h5><i class="bi bi-images me-2" style="color:var(--admin-secondary);"></i>Slides du Carousel</h5>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-admin">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle slide
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Aperçu</th>
                    <th>Titre</th>
                    <th>Sous-titre</th>
                    <th>Bouton</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr>
                        <td>
                            <span style="background:var(--admin-secondary); color:#000; width:30px; height:30px;
                                         border-radius:50%; display:inline-flex; align-items:center; justify-content:center;
                                         font-weight:700; font-size:.85rem;">
                                {{ $slider->order }}
                            </span>
                        </td>
                        <td>
                            <img src="{{ $slider->image_url }}"
                                 alt="{{ $slider->title }}"
                                 style="height:55px; width:110px; object-fit:cover; border-radius:6px;">
                        </td>
                        <td style="font-weight:600; font-size:.9rem;">{{ $slider->title }}</td>
                        <td class="small text-muted">{{ Str::limit($slider->subtitle, 50) }}</td>
                        <td class="small">
                            {{ $slider->button_text ?? '—' }}
                        </td>
                        <td>
                            @if($slider->is_active)
                                <span class="badge" style="background:#d1fae5; color:#065f46; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Actif</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:.72rem; padding:.35rem .7rem; border-radius:20px;">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.sliders.edit', $slider) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.sliders.destroy', $slider) }}"
                                      onsubmit="return confirm('Supprimer cette slide ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-images" style="font-size:2.5rem; display:block; margin-bottom:.5rem;"></i>
                            Aucune slide configurée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
