<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = Auth::user()->vendor;
        $products = Product::where('vendor_id', $vendor->id)
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('vendor.products.index', compact('products', 'vendor'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nom'         => 'required|string|max:255',
        'prix'        => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $vendor = Auth::user()->vendor;

    // Gérer l'image
    $imagePath = null;
    if ($request->hasFile('image_file')) {
        $file = $request->file('image_file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/products'), $filename);
        $imagePath = 'images/products/' . $filename;
    } elseif ($request->image) {
        $imagePath = $request->image;
    }

    Product::create([
        'nom'         => $request->nom,
        'slug'        => Str::slug($request->nom) . '-' . uniqid(),
        'description' => $request->description,
        'prix'        => $request->prix,
        'prix_promo'  => $request->prix_promo,
        'stock'       => $request->stock,
        'image'       => $imagePath,
        'category_id' => $request->category_id,
        'vendor_id'   => $vendor->id,
        'statut'      => 'en_attente',
    ]);

    return redirect()->route('vendor.products.index')
        ->with('success', 'Produit ajouté ! En attente de validation par l\'admin.');
}

public function update(Request $request, Product $product)
{
    if ($product->vendor_id != Auth::user()->vendor->id) {
        abort(403);
    }

    $request->validate([
        'nom'         => 'required|string|max:255',
        'prix'        => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Gérer l'image
    $imagePath = $product->image;
    if ($request->hasFile('image_file')) {
        $file = $request->file('image_file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/products'), $filename);
        $imagePath = 'images/products/' . $filename;
    } elseif ($request->image) {
        $imagePath = $request->image;
    }

    $product->update([
        'nom'         => $request->nom,
        'description' => $request->description,
        'prix'        => $request->prix,
        'prix_promo'  => $request->prix_promo,
        'stock'       => $request->stock,
        'image'       => $imagePath,
        'category_id' => $request->category_id,
        'statut'      => 'en_attente',
    ]);

    return redirect()->route('vendor.products.index')
        ->with('success', 'Produit modifié ! En attente de validation.');
}
    public function destroy(Product $product)
    {
        if ($product->vendor_id != Auth::user()->vendor->id) {
            abort(403);
        }
        $product->delete();
        return redirect()->route('vendor.products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }

    public function show(Product $product)
    {
        return redirect()->route('vendor.products.index');
    }
}