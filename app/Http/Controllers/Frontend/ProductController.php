<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Liste de tous les produits actifs.
     */
    public function index()
    {
        $products = Product::active()->latest()->paginate(12);
        return view('frontend.products.index', compact('products'));
    }

    /**
     * Détail d'un produit.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(3)->get();

        return view('frontend.products.show', compact('product', 'related'));
    }
}
