<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private CartService $cart) {}

    /** Page de confirmation / récapitulatif avant paiement */
    public function checkout()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        $items = $this->cart->getItems();
        $total = $this->cart->getTotal();

        return view('frontend.orders.checkout', compact('items', 'total'));
    }

    /** Valider et enregistrer la commande */
    public function store(StoreOrderRequest $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        $items = $this->cart->getItems();

        // Déterminer le type global de la commande
        // S'il y a un seul type dans le panier, on l'utilise.
        // S'il y en a plusieurs, on met "detail" (les articles gros seront identifiés par unit_price null).
        $types      = array_unique(array_column($items, 'type'));
        $orderType  = count($types) === 1 ? $types[0] : 'detail';

        // Calculer le total (seulement pour les articles détail)
        $total = $this->cart->getTotal();
        $totalValue = ($orderType === 'gros' && !$this->cart->hasGros() === false)
            ? null
            : ($total > 0 ? $total : null);

        // Si tous les articles sont en gros, total = null
        if ($orderType === 'gros') {
            $totalValue = null;
        }

        DB::beginTransaction();
        try {
            // Créer la commande
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'phone'         => $request->phone,
                'city'          => $request->city,
                'address'       => $request->address,
                'type'          => $orderType,
                'total'         => $totalValue,
                'status'        => 'pending',
            ]);

            // Créer les items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }

            DB::commit();

            // Vider le panier
            $this->cart->clear();

            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    /** Page de succès après commande */
    public function success(Order $order)
    {
        $order->load('items.product');
        return view('frontend.orders.success', compact('order'));
    }
}
