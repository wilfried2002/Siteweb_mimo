<?php

namespace App\Http\Controllers\Magasinier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Only shows validated+ orders (magasinier handles fulfillment)
    public function index(Request $request)
    {
        $query = Order::with('items.product')
            ->whereNotIn('status', ['pending', 'cancelled'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20)->withQueryString();
        $stats  = [
            'validated'      => Order::where('status', 'validated')->count(),
            'en_preparation' => Order::where('status', 'en_preparation')->count(),
            'expediee'       => Order::where('status', 'expediee')->count(),
            'livree'         => Order::where('status', 'livree')->count(),
        ];

        return view('magasinier.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('magasinier.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $allowed = ['en_preparation', 'expediee', 'livree'];

        $request->validate([
            'status'        => 'required|in:' . implode(',', $allowed),
            'delivery_date' => 'nullable|date',
        ]);

        // Enforce progression order
        $flow = ['validated', 'en_preparation', 'expediee', 'livree'];
        $current = array_search($order->status, $flow);
        $next    = array_search($request->status, $flow);

        if ($next === false || $next <= $current) {
            return back()->with('error', 'Transition de statut invalide.');
        }

        $order->update([
            'status'        => $request->status,
            'delivery_date' => $request->delivery_date,
        ]);

        return back()->with('success', 'Statut mis à jour : ' . $order->fresh()->status_label);
    }
}
