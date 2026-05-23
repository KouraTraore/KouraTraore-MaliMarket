<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total'       => Order::count(),
            'en_attente'  => Order::where('statut', 'en_attente')->count(),
            'en_livraison'=> Order::where('statut', 'en_livraison')->count(),
            'livrees'     => Order::where('statut', 'livree')->count(),
            'annulees'    => Order::where('statut', 'annulee')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'items.vendor'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatut(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,en_livraison,livree,annulee'
        ]);

        $order->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut mis à jour avec succès !');
    }
}