<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommandeConfirmation;

class OrderController extends Controller
{
   public function checkout()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Votre panier est vide !');
    }

    $zones = \App\Models\ZoneLivraison::orderBy('frais')->orderBy('quartier')->get();

    return view('shop.checkout', compact('zones'));
}

    public function store(Request $request)
{
    $request->validate([
        'nom_livraison'       => 'required|string|max:255',
        'telephone_livraison' => 'required|string|max:20',
        'adresse_livraison'   => 'required|string|max:255',
        'zone_id'             => 'required|exists:zones_livraison,id',
        'mode_paiement'       => 'required|in:livraison,orange_money,moov_money',
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Votre panier est vide !');
    }

    $zone = \App\Models\ZoneLivraison::findOrFail($request->zone_id);

    $sousTotal = array_sum(array_map(
        fn($item) => $item['prix'] * $item['quantite'], $cart
    ));

    $fraisLivraison = $zone->frais;
    $total = $sousTotal + $fraisLivraison;

    $order = null;

    DB::transaction(function () use ($request, $cart, $total, $sousTotal, $fraisLivraison, $zone, &$order) {
        $order = Order::create([
            'user_id'             => Auth::id(),
            'numero'              => 'MM-' . date('Ymd') . '-' . strtoupper(uniqid()),
            'montant_total'       => $total,
            'statut'              => 'en_attente',
            'mode_paiement'       => $request->mode_paiement,
            'statut_paiement'     => 'non_paye',
            'nom_livraison'       => $request->nom_livraison,
            'telephone_livraison' => $request->telephone_livraison,
            'adresse_livraison'   => $request->adresse_livraison,
            'ville_livraison'     => $zone->quartier . ', ' . $zone->ville,
            'notes'               => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['product_id'],
                'vendor_id'     => $item['vendor_id'],
                'quantite'      => $item['quantite'],
                'prix_unitaire' => $item['prix'],
                'sous_total'    => $item['prix'] * $item['quantite'],
            ]);

            Product::where('id', $item['product_id'])
                ->decrement('stock', $item['quantite']);
        }

        session()->forget('cart');
    });

    // Envoyer email de confirmation
    try {
        $order->load('items.product', 'user');
        Mail::to($order->user->email)->send(new CommandeConfirmation($order));
    } catch (\Exception $e) {
        //
    }

    return redirect()->route('orders.index')
        ->with('success', '🎉 Commande passée avec succès ! Un email de confirmation vous a été envoyé.');
}
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('shop.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        return view('shop.order_detail', compact('order'));
    }
}