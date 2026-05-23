<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')
            ->latest()
            ->paginate(10);

        $stats = [
            'total'      => Vendor::count(),
            'approuve'   => Vendor::where('statut', 'approuve')->count(),
            'en_attente' => Vendor::where('statut', 'en_attente')->count(),
            'suspendu'   => Vendor::where('statut', 'suspendu')->count(),
        ];

        return view('admin.vendors.index', compact('vendors', 'stats'));
    }

    public function approve($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->update(['statut' => 'approuve']);
        return back()->with('success', 'Vendeur approuvé avec succès !');
    }

    public function suspend($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->update(['statut' => 'suspendu']);
        return back()->with('success', 'Vendeur suspendu !');
    }
}