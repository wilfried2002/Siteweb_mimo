<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    /** Afficher le panier */
    public function index()
    {
        $items = $this->cart->getItems();
        $total = $this->cart->getTotal();
        return view('frontend.cart.index', compact('items', 'total'));
    }

    /** Ajouter un produit au panier (POST AJAX ou formulaire) */
    public function add(AddToCartRequest $request)
    {
        try {
            $this->cart->add(
                (int) $request->product_id,
                (int) $request->quantity,
                $request->type
            );

            $message = $request->type === 'gros'
                ? 'Produit ajouté au panier (commande en gros).'
                : 'Produit ajouté au panier.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success'    => true,
                    'message'    => $message,
                    'cart_count' => $this->cart->count(),
                    'cart_total' => number_format($this->cart->getTotal(), 0, ',', '.'),
                ]);
            }

            return back()->with('success', $message);

        } catch (\InvalidArgumentException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['quantity' => $e->getMessage()]);
        }
    }

    /** Mettre à jour la quantité d'une ligne */
    public function update(string $cartKey)
    {
        $quantity = (int) request('quantity', 0);

        try {
            $this->cart->updateQuantity($cartKey, $quantity);
            return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('cart.index')->withErrors(['quantity' => $e->getMessage()]);
        }
    }

    /** Supprimer une ligne du panier */
    public function remove(string $cartKey)
    {
        $this->cart->remove($cartKey);
        return redirect()->route('cart.index')->with('success', 'Article retiré du panier.');
    }

    /** Vider entièrement le panier */
    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }
}
