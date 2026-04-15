<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('phone', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'validated' => Order::where('status', 'validated')->count(),
            'gros'      => Order::where('type', 'gros')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /** Changer le statut d'une commande */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,validated,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour : ' . $order->status_label);
    }

    /** Ajouter une note admin */
    public function updateNotes(Request $request, Order $order)
    {
        $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $order->update(['notes' => $request->notes]);

        return back()->with('success', 'Note enregistrée.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée.');
    }
}
