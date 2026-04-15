<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

/**
 * CartService — Gestion du panier en session.
 *
 * Structure session['mimosa_cart']:
 * [
 *   'items' => [
 *     [
 *       'cart_key'     => 'product_1_detail',  // clé unique
 *       'product_id'   => 1,
 *       'product_name' => 'Farine Premium 1kg',
 *       'product_image'=> 'products/...',
 *       'quantity'     => 2,
 *       'type'         => 'detail',   // ou 'gros'
 *       'unit_price'   => 2500.00,    // null si gros
 *       'subtotal'     => 5000.00,    // null si gros
 *     ],
 *   ],
 * ]
 */
class CartService
{
    private const KEY = 'mimosa_cart';

    // ─────────────────────────────────────────────────────
    // LECTURE
    // ─────────────────────────────────────────────────────

    /** Retourne tous les articles du panier */
    public function getItems(): array
    {
        return Session::get(self::KEY . '.items', []);
    }

    /** Nombre d'articles (lignes) dans le panier */
    public function count(): int
    {
        return count($this->getItems());
    }

    /** Somme totale des quantités */
    public function totalQty(): int
    {
        return array_sum(array_column($this->getItems(), 'quantity'));
    }

    /** Total financier (uniquement commandes détail) */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            if ($item['type'] === 'detail' && isset($item['subtotal'])) {
                $total += $item['subtotal'];
            }
        }
        return $total;
    }

    /** Indique si le panier contient au moins un article en gros */
    public function hasGros(): bool
    {
        foreach ($this->getItems() as $item) {
            if ($item['type'] === 'gros') return true;
        }
        return false;
    }

    /** Panier vide ? */
    public function isEmpty(): bool
    {
        return empty($this->getItems());
    }

    // ─────────────────────────────────────────────────────
    // ÉCRITURE
    // ─────────────────────────────────────────────────────

    /**
     * Ajouter ou mettre à jour un produit dans le panier.
     *
     * @throws \InvalidArgumentException si gros < 100
     */
    public function add(int $productId, int $quantity, string $type): void
    {
        // Règle métier : gros minimum 100 sacs
        if ($type === 'gros' && $quantity < 100) {
            throw new \InvalidArgumentException(
                'La commande en gros nécessite un minimum de 100 sacs. Quantité saisie : ' . $quantity . '.'
            );
        }

        if ($quantity <= 0) {
            throw new \InvalidArgumentException('La quantité doit être supérieure à 0.');
        }

        $product  = Product::findOrFail($productId);
        $cartKey  = 'product_' . $productId . '_' . $type;
        $items    = $this->getItems();

        // Chercher si la ligne existe déjà (même produit + même type)
        $index = $this->findIndex($items, $cartKey);

        $unitPrice = ($type === 'detail') ? (float) $product->price : null;

        if ($index !== null) {
            // Mise à jour de la quantité
            $newQty = $items[$index]['quantity'] + $quantity;

            if ($type === 'gros' && $newQty < 100) {
                throw new \InvalidArgumentException(
                    'La commande en gros nécessite un minimum de 100 sacs au total.'
                );
            }

            $items[$index]['quantity'] = $newQty;
            $items[$index]['subtotal'] = $unitPrice ? round($unitPrice * $newQty, 2) : null;
        } else {
            $items[] = [
                'cart_key'      => $cartKey,
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'product_image' => $product->image,
                'product_weight'=> $product->weight,
                'quantity'      => $quantity,
                'type'          => $type,
                'unit_price'    => $unitPrice,
                'subtotal'      => $unitPrice ? round($unitPrice * $quantity, 2) : null,
            ];
        }

        Session::put(self::KEY . '.items', $items);
    }

    /** Supprimer une ligne du panier par sa cart_key */
    public function remove(string $cartKey): void
    {
        $items = array_filter(
            $this->getItems(),
            fn($item) => $item['cart_key'] !== $cartKey
        );
        Session::put(self::KEY . '.items', array_values($items));
    }

    /** Modifier la quantité d'une ligne */
    public function updateQuantity(string $cartKey, int $quantity): void
    {
        $items = $this->getItems();
        $index = $this->findIndex($items, $cartKey);

        if ($index === null) return;

        $item = $items[$index];

        if ($item['type'] === 'gros' && $quantity < 100) {
            throw new \InvalidArgumentException(
                'La commande en gros nécessite un minimum de 100 sacs.'
            );
        }

        if ($quantity <= 0) {
            $this->remove($cartKey);
            return;
        }

        $items[$index]['quantity'] = $quantity;
        $items[$index]['subtotal'] = $item['unit_price']
            ? round($item['unit_price'] * $quantity, 2)
            : null;

        Session::put(self::KEY . '.items', $items);
    }

    /** Vider entièrement le panier */
    public function clear(): void
    {
        Session::forget(self::KEY);
    }

    // ─────────────────────────────────────────────────────
    // UTILITAIRES PRIVÉES
    // ─────────────────────────────────────────────────────

    private function findIndex(array $items, string $cartKey): ?int
    {
        foreach ($items as $i => $item) {
            if ($item['cart_key'] === $cartKey) return $i;
        }
        return null;
    }
}
