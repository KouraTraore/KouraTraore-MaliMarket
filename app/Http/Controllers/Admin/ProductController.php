<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'vendor'])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->get();
        $vendors = Vendor::where('statut', 'approuve')->get();
        return view('admin.products.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id'   => 'required|exists:vendors,id',
        ]);

        Product::create([
            'nom'         => $request->nom,
            'slug'        => Str::slug($request->nom) . '-' . uniqid(),
            'description' => $request->description,
            'prix'        => $request->prix,
            'prix_promo'  => $request->prix_promo,
            'stock'       => $request->stock,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'vendor_id'   => $request->vendor_id,
            'statut'      => $request->statut ?? 'actif',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->get();
        $vendors = Vendor::where('statut', 'approuve')->get();
        return view('admin.products.edit', compact('product', 'categories', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id'   => 'required|exists:vendors,id',
        ]);

        $product->update([
            'nom'         => $request->nom,
            'description' => $request->description,
            'prix'        => $request->prix,
            'prix_promo'  => $request->prix_promo,
            'stock'       => $request->stock,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'vendor_id'   => $request->vendor_id,
            'statut'      => $request->statut,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit modifié avec succès !');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.index');
    }
}