<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('active', true)->get();
        $produitsRecents = Product::with(['vendor', 'category'])
            ->where('statut', 'actif')
            ->latest()
            ->take(8)
            ->get();
        $produitsPopulaires = Product::with(['vendor', 'category'])
            ->where('statut', 'actif')
            ->orderBy('vues', 'desc')
            ->take(8)
            ->get();

        return view('shop.home', compact(
            'categories',
            'produitsRecents',
            'produitsPopulaires'
        ));
    }

    public function show($slug)
    {
        $product = Product::with(['vendor', 'category'])
            ->where('slug', $slug)
            ->where('statut', 'actif')
            ->firstOrFail();

        $product->increment('vues');

        $produitsSimiliaires = Product::with(['vendor', 'category'])
            ->where('category_id', $product->category_id)
            ->where('statut', 'actif')
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'produitsSimiliaires'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['vendor', 'category'])
            ->where('category_id', $category->id)
            ->where('statut', 'actif')
            ->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with(['vendor', 'category'])
            ->where('statut', 'actif')
            ->where(function($q) use ($query) {
                $q->where('nom', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(12);

        return view('shop.search', compact('products', 'query'));
    }
}