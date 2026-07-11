@extends('layouts.admin')
@section('title', 'Ordre des produits en vedette')
@section('page-title', 'Ordre d\'affichage — Produits en vedette')

@push('styles')
<style>
.sortable-list {
    list-style: none;
    padding: 0;
    margin: 0;
    max-width: 680px;
}
.sortable-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: .85rem 1.2rem;
    margin-bottom: .6rem;
    cursor: grab;
    transition: box-shadow .2s, transform .15s;
    user-select: none;
}
.sortable-item:active { cursor: grabbing; }
.sortable-item.sortable-ghost {
    opacity: .35;
    background: #f0f4ff;
}
.sortable-item.sortable-drag {
    box-shadow: 0 8px 30px rgba(0,0,0,.18);
    transform: rotate(1.5deg);
    border-color: var(--admin-secondary, #c8a84b);
    cursor: grabbing;
}
.drag-handle {
    color: #adb5bd;
    font-size: 1.2rem;
    flex-shrink: 0;
    cursor: grab;
}
.drag-handle:hover { color: #6c757d; }
.item-rank {
    width: 28px;
    height: 28px;
    background: var(--admin-secondary, #c8a84b);
    color: #1a3a5c;
    border-radius: 50%;
    font-weight: 700;
    font-size: .8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.item-thumb {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}
.item-info { flex: 1; min-width: 0; }
.item-info strong { display: block; font-size: .92rem; color: #1a3a5c; }
.item-info span  { font-size: .75rem; color: #94a3b8; }
.save-banner {
    position: fixed;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%) translateY(120%);
    background: #1a3a5c;
    color: #fff;
    padding: .85rem 2rem;
    border-radius: 50px;
    box-shadow: 0 8px 30px rgba(0,0,0,.2);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 1rem;
    white-space: nowrap;
}
.save-banner.visible { transform: translateX(-50%) translateY(0); }
.save-banner .btn-save {
    background: #c8a84b;
    color: #1a3a5c;
    border: none;
    border-radius: 30px;
    padding: .4rem 1.2rem;
    font-weight: 700;
    font-size: .85rem;
    cursor: pointer;
    transition: background .2s;
}
.save-banner .btn-save:hover { background: #b8962f; }
.save-banner .btn-save:disabled { opacity: .6; cursor: default; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4" style="max-width:680px;">
    <div>
        <p class="text-muted mb-0" style="font-size:.88rem;">
            <i class="bi bi-grip-vertical me-1"></i>
            Glissez-déposez les produits pour définir leur ordre d'affichage sur la page d'accueil.
        </p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

@if($featured->isEmpty())
    <div style="max-width:680px;">
        <div class="table-card text-center py-5">
            <i class="bi bi-star" style="font-size:2.5rem; color:#c8a84b; display:block; margin-bottom:1rem;"></i>
            <h5 style="color:#1a3a5c;">Aucun produit en vedette</h5>
            <p class="text-muted mb-4">Activez l'option "En vedette" sur au moins un produit pour pouvoir configurer leur ordre d'affichage.</p>
            <a href="{{ route('admin.products.index') }}" class="btn btn-admin">
                <i class="bi bi-bag me-2"></i>Gérer les produits
            </a>
        </div>
    </div>
@else
    <ul class="sortable-list" id="sortableList">
        @foreach($featured as $i => $product)
            <li class="sortable-item" data-id="{{ $product->id }}">
                <span class="drag-handle"><i class="bi bi-grip-vertical"></i></span>
                <span class="item-rank">{{ $i + 1 }}</span>
                <img class="item-thumb"
                     src="{{ $product->image_url }}"
                     alt="{{ $product->name }}">
                <div class="item-info">
                    <strong>{{ $product->name }}</strong>
                    <span>{{ ucfirst($product->category) }}
                        @if($product->weight) · {{ $product->weight }} @endif
                        @if($product->price) · {{ number_format($product->price, 0, ',', '.') }} FC @endif
                    </span>
                </div>
                <span style="font-size:.72rem; background:#fef3c7; color:#92400e; padding:.25rem .6rem; border-radius:20px;">
                    <i class="bi bi-star-fill me-1"></i>Vedette
                </span>
            </li>
        @endforeach
    </ul>

    {{-- Bandeau de sauvegarde flottant --}}
    <div class="save-banner" id="saveBanner">
        <span><i class="bi bi-arrow-up-down me-2"></i>Ordre modifié</span>
        <button class="btn-save" id="btnSave" onclick="saveOrder()">
            <i class="bi bi-check2 me-1"></i>Enregistrer
        </button>
        <button onclick="cancelOrder()" style="background:none; border:none; color:rgba(255,255,255,.6); font-size:1.1rem; cursor:pointer; padding:0;">
            <i class="bi bi-x"></i>
        </button>
    </div>
@endif

@endsection

@push('scripts')
{{-- SortableJS (CDN, admin uniquement) --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
const list   = document.getElementById('sortableList');
const banner = document.getElementById('saveBanner');
let   originalOrder = [];
let   changed = false;

if (list) {
    // Capture l'ordre initial
    originalOrder = [...list.querySelectorAll('[data-id]')].map(el => el.dataset.id);

    Sortable.create(list, {
        handle: '.drag-handle',
        animation: 180,
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd() {
            updateRanks();
            changed = true;
            banner.classList.add('visible');
        }
    });
}

function updateRanks() {
    list.querySelectorAll('.item-rank').forEach((el, i) => {
        el.textContent = i + 1;
    });
}

function saveOrder() {
    const btn = document.getElementById('btnSave');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Enregistrement…';

    const ids = [...list.querySelectorAll('[data-id]')].map(el => parseInt(el.dataset.id));

    fetch('{{ route('admin.products.save-order') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ ids })
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            btn.innerHTML = '<i class="bi bi-check2 me-1"></i>Enregistré !';
            btn.style.background = '#10b981';
            setTimeout(() => {
                banner.classList.remove('visible');
                changed = false;
                originalOrder = [...list.querySelectorAll('[data-id]')].map(el => el.dataset.id);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check2 me-1"></i>Enregistrer';
                btn.style.background = '';
            }, 1500);
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Erreur — Réessayer';
        btn.style.background = '#ef4444';
    });
}

function cancelOrder() {
    // Restaure l'ordre original visuellement
    originalOrder.forEach(id => {
        const el = list.querySelector(`[data-id="${id}"]`);
        if (el) list.appendChild(el);
    });
    updateRanks();
    changed = false;
    banner.classList.remove('visible');
}

window.addEventListener('beforeunload', e => {
    if (changed) { e.preventDefault(); e.returnValue = ''; }
});
</script>
@endpush
