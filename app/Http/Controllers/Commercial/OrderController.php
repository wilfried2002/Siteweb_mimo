<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        $orders  = $query->paginate(20)->withQueryString();
        $stats   = [
            'pending'   => Order::where('status', 'pending')->count(),
            'validated' => Order::where('status', 'validated')->count(),
            'total'     => Order::count(),
        ];

        return view('commercial.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('commercial.orders.show', compact('order'));
    }

    public function validate(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Cette commande ne peut pas être validée.');
        }

        $order->update(['status' => 'validated']);
        return back()->with('success', 'Commande validée avec succès.');
    }

    public function reject(Order $order)
    {
        if (!in_array($order->status, ['pending', 'validated'])) {
            return back()->with('error', 'Cette commande ne peut pas être annulée.');
        }

        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Commande annulée.');
    }

    public function updateNotes(Request $request, Order $order)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);
        $order->update(['notes' => $request->notes]);
        return back()->with('success', 'Notes mises à jour.');
    }
}
