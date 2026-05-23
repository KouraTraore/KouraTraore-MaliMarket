<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['prix'] * $item['quantite'], $cart));
        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantite'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantite'] += $request->quantite;
        } else {
            $cart[$product->id] = [
                'product_id'  => $product->id,
                'nom'         => $product->nom,
                'prix'        => $product->prixFinal(),
                'image'       => $product->image,
                'quantite'    => $request->quantite,
                'vendor_id'   => $product->vendor_id,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantite'] = $request->quantite;
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Panier mis à jour !');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Produit retiré du panier !');
    }
} 