<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('home')
                ->with('error', 'Vous n\'avez pas encore de boutique !');
        }

        $totalProduits  = Product::where('vendor_id', $vendor->id)->count();
        $totalVentes    = OrderItem::where('vendor_id', $vendor->id)->sum('sous_total');
        $totalCommandes = OrderItem::where('vendor_id', $vendor->id)
            ->distinct('order_id')->count('order_id');

        $topProduits = Product::select('products.*',
            DB::raw('COALESCE(SUM(order_items.quantite), 0) as total_vendus')
        )
        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        ->where('products.vendor_id', $vendor->id)
        ->groupBy('products.id')
        ->orderBy('total_vendus', 'desc')
        ->take(5)
        ->get();

        $dernieresCommandes = Order::whereHas('items', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->with('user')
        ->latest()
        ->take(5)
        ->get();

        return view('vendor.dashboard', compact(
            'vendor', 'totalProduits', 'totalVentes',
            'totalCommandes', 'topProduits', 'dernieresCommandes'
        ));
    }
}