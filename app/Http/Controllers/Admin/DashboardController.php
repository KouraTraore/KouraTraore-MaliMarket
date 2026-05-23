<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVentes = Order::where('statut_paiement', 'paye')->sum('montant_total');
        $totalCommandes = Order::count();
        $totalClients = User::where('role', 'client')->count();
        $totalVendeurs = Vendor::where('statut', 'approuve')->count();
        $totalProduits = Product::count();
        $commandesEnAttente = Order::where('statut', 'en_attente')->count();
        $vendeursEnAttente = Vendor::where('statut', 'en_attente')->count();

        $commandesMois = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%b %Y") as mois'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(montant_total) as revenus')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('mois')
        ->orderByRaw('MIN(created_at)')
        ->get();

        $moisLabels = $commandesMois->pluck('mois');
        $moisData   = $commandesMois->pluck('revenus');

        $topProduits = Product::select('products.*',
            DB::raw('SUM(order_items.quantite) as total_vendus')
        )
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->groupBy('products.id')
        ->orderBy('total_vendus', 'desc')
        ->take(5)
        ->get();

        $dernieresCommandes = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $vendeursAttente = Vendor::with('user')
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVentes', 'totalCommandes', 'totalClients',
            'totalVendeurs', 'totalProduits', 'commandesEnAttente',
            'vendeursEnAttente', 'moisLabels', 'moisData',
            'topProduits', 'dernieresCommandes', 'vendeursAttente'
        ));
    }
}