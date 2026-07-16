<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function reorder()
    {
        $featured = Product::where('is_featured', true)->orderBy('sort_order')->get();
        return view('admin.products.order', compact('featured'));
    }

    public function saveOrder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:products,id',
        ]);

        foreach ($data['ids'] as $position => $id) {
            Product::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['ok' => true]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'weight'      => ['nullable', 'string', 'max:50'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_featured' => ['boolean'],
            'is_active'   => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'images');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active');

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'weight'      => ['nullable', 'string', 'max:50'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_featured' => ['boolean'],
            'is_active'   => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::disk('images')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'images');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        // Si le produit est lié à des commandes, on désactive plutôt que de supprimer
        // (la contrainte FK restrict protège l'historique des commandes)
        if ($product->orderItems()->exists()) {
            $product->update(['is_active' => false]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Ce produit est lié à des commandes existantes : il a été désactivé (masqué du site) pour préserver l\'historique.');
        }

        if ($product->image) {
            Storage::disk('images')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}
