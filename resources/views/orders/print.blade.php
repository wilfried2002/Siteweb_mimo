<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $docTitle }} — Commande #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 13px;
        color: #1a1a1a;
        background: #fff;
        padding: 0;
    }

    /* ── Écran : cadre A4 centré ── */
    @media screen {
        body { background: #e5e7eb; padding: 2rem; }
        .page { background: #fff; max-width: 794px; margin: 0 auto;
                box-shadow: 0 4px 24px rgba(0,0,0,.15); padding: 2.5rem; }
        .no-print-bar {
            max-width: 794px; margin: 0 auto 1rem;
            display: flex; gap: .75rem; align-items: center;
        }
    }
    /* ── Impression ── */
    @media print {
        body { background: #fff; padding: 0; }
        .page { padding: 1.5cm 2cm; }
        .no-print-bar { display: none !important; }
        @page { size: A4; margin: 0; }
    }

    /* ── Barre boutons (écran seulement) ── */
    .no-print-bar .btn-print {
        background: #1a3a5c; color: #fff; border: none;
        padding: .6rem 1.4rem; border-radius: 6px; cursor: pointer;
        font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: .5rem;
    }
    .no-print-bar .btn-close-tab {
        background: transparent; border: 1px solid #d1d5db; color: #6b7280;
        padding: .6rem 1.2rem; border-radius: 6px; cursor: pointer; font-size: .9rem;
    }

    /* ── En-tête société ── */
    .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 1.2rem;
        border-bottom: 3px solid #1a3a5c;
        margin-bottom: 1.5rem;
    }
    .company-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a3a5c;
        letter-spacing: -.5px;
        line-height: 1.1;
    }
    .company-sub { font-size: .78rem; color: #64748b; margin-top: .25rem; }
    .doc-title-box { text-align: right; }
    .doc-title-box h1 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #c8a84b;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .doc-title-box .order-num {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a3a5c;
        font-family: monospace;
    }
    .doc-title-box .doc-date { font-size: .78rem; color: #64748b; margin-top: .2rem; }

    /* ── Badge phase ── */
    .phase-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: .8rem;
        margin-bottom: 1.5rem;
        border: 1.5px solid currentColor;
    }

    /* ── Section ── */
    .section { margin-bottom: 1.5rem; }
    .section-title {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: .4rem;
        margin-bottom: .8rem;
    }

    /* ── Info boxes ── */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem 1.5rem; }
    .info-item .label { font-size: .72rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; }
    .info-item .value { font-weight: 600; color: #1e293b; margin-top: .1rem; }

    /* ── Table articles ── */
    table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
    thead tr { background: #1a3a5c; color: #fff; }
    thead th { padding: .6rem .8rem; font-size: .78rem; font-weight: 600;
                text-align: left; letter-spacing: .3px; }
    thead th.r { text-align: right; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody td { padding: .55rem .8rem; border-bottom: 1px solid #f1f5f9; font-size: .85rem; }
    tbody td.r { text-align: right; }
    tfoot tr { background: #1a3a5c; }
    tfoot td { padding: .7rem .8rem; color: #fff; font-weight: 700; font-size: .9rem; }
    tfoot td.r { text-align: right; color: #c8a84b; font-size: 1rem; }

    /* ── Notes ── */
    .notes-box {
        background: #fef9ee;
        border-left: 3px solid #c8a84b;
        padding: .75rem 1rem;
        border-radius: 0 6px 6px 0;
        font-size: .85rem;
        color: #44403c;
        white-space: pre-line;
    }

    /* ── Signatures ── */
    .signatures {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px dashed #cbd5e1;
    }
    .sig-box { text-align: center; }
    .sig-line {
        border-bottom: 1px solid #1a3a5c;
        height: 48px;
        margin-bottom: .4rem;
    }
    .sig-label { font-size: .72rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }

    /* ── Pied de page ── */
    .doc-footer {
        margin-top: 1.5rem;
        padding-top: .75rem;
        border-top: 1px solid #e5e7eb;
        font-size: .7rem;
        color: #94a3b8;
        display: flex;
        justify-content: space-between;
    }

    /* ── Alerte gros ── */
    .gros-alert {
        background: #fef3c7; border: 1px solid #fde68a;
        border-radius: 6px; padding: .65rem 1rem;
        font-size: .8rem; color: #92400e; margin-bottom: 1rem;
    }
</style>
</head>
<body>

{{-- Barre boutons (visible uniquement à l'écran) --}}
<div class="no-print-bar">
    <button class="btn-print" onclick="window.print()">
        🖨️ Imprimer / Enregistrer PDF
    </button>
    <button class="btn-close-tab" onclick="window.close()">✕ Fermer</button>
    <span style="font-size:.8rem; color:#6b7280;">Format A4 — impression optimisée</span>
</div>

<div class="page">

    {{-- En-tête --}}
    <div class="doc-header">
        <div style="display:flex; align-items:center; gap:1rem;">
            <img src="{{ asset('assets/images/logo.jpg') }}"
                 alt="Mimosa Flour"
                 style="height:72px; width:auto; object-fit:contain;">
            <div>
                <div class="company-name">MIMOSA FLOUR</div>
                <div class="company-sub">
                    Minoterie Mimosa — Douala, Cameroun<br>
                    Tél : +237 620 73 19 30 &nbsp;|&nbsp; info@mimosaflour.com
                </div>
            </div>
        </div>
        <div class="doc-title-box">
            <h1>{{ $docTitle }}</h1>
            <div class="order-num">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="doc-date">
                Émis le {{ now()->format('d/m/Y à H:i') }}<br>
                Commande du {{ $order->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- Badge phase --}}
    <span class="phase-badge" style="{{ $order->status_bg }}">
        {{ $phaseIcon }} {{ $order->status_label }}
        @if($order->type === 'gros')
            &nbsp;·&nbsp; COMMANDE EN GROS
        @else
            &nbsp;·&nbsp; COMMANDE EN DÉTAIL
        @endif
    </span>

    {{-- Infos client --}}
    <div class="section">
        <div class="section-title">Informations Client</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Nom / Raison sociale</div>
                <div class="value">{{ $order->customer_name ?: '— Non renseigné —' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Téléphone</div>
                <div class="value">{{ $order->phone }}</div>
            </div>
            @if($order->city)
            <div class="info-item">
                <div class="label">Ville</div>
                <div class="value">{{ $order->city }}</div>
            </div>
            @endif
            @if($order->address)
            <div class="info-item">
                <div class="label">Adresse de livraison</div>
                <div class="value">{{ $order->address }}</div>
            </div>
            @endif
            @if($order->delivery_date)
            <div class="info-item">
                <div class="label">Date de livraison prévue</div>
                <div class="value">{{ $order->delivery_date->format('d/m/Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Articles --}}
    <div class="section">
        <div class="section-title">Articles Commandés</div>

        @if($order->type === 'gros')
        <div class="gros-alert">
            ⚠️ Commande en gros — Le prix définitif doit être communiqué au client par téléphone avant expédition.
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Poids</th>
                    <th class="r">Quantité</th>
                    <th class="r">Prix unitaire</th>
                    <th class="r">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td>{{ $item->product?->weight ?? '—' }}</td>
                    <td class="r"><strong>{{ $item->quantity }}</strong></td>
                    <td class="r">{{ $item->unit_price ? number_format($item->unit_price, 0, ',', '.') . ' FCFA' : 'Sur devis' }}</td>
                    <td class="r"><strong>{{ $item->subtotal ? number_format($item->subtotal, 0, ',', '.') . ' FCFA' : 'Sur devis' }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">TOTAL COMMANDE ({{ $order->items->sum('quantity') }} article(s))</td>
                    <td class="r">{{ $order->total ? number_format($order->total, 0, ',', '.') . ' FCFA' : 'Sur devis' }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Notes --}}
    @if($order->notes)
    <div class="section">
        <div class="section-title">Notes internes</div>
        <div class="notes-box">{{ $order->notes }}</div>
    </div>
    @endif

    {{-- Signatures --}}
    <div class="signatures">
        <div class="sig-box">
            <div class="sig-line"></div>
            <div class="sig-label">Commercial / Préparateur</div>
        </div>
        <div class="sig-box">
            <div class="sig-line"></div>
            <div class="sig-label">Responsable entrepôt</div>
        </div>
        <div class="sig-box">
            <div class="sig-line"></div>
            <div class="sig-label">
                @if(in_array($order->status, ['expediee','livree']))
                    Signature Client / Livreur
                @else
                    Validation Hiérarchique
                @endif
            </div>
        </div>
    </div>

    {{-- Pied de page --}}
    <div class="doc-footer">
        <span>Mimosa Flour — RCCM Douala — B.P. 2754 Douala, Cameroun</span>
        <span>Document généré le {{ now()->format('d/m/Y à H:i') }} — Réf. CMD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

</div>

<script>
    // Impression automatique si ?auto=1
    if (new URLSearchParams(window.location.search).get('auto') === '1') {
        window.addEventListener('load', () => setTimeout(() => window.print(), 400));
    }
</script>
</body>
</html>
