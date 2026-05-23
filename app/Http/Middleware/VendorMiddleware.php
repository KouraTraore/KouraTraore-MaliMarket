<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isVendeur()) {
            return redirect()->route('home')
                ->with('error', 'Accès réservé aux vendeurs !');
        }

        if (auth()->user()->vendor && auth()->user()->vendor->statut == 'suspendu') {
            return redirect()->route('home')
                ->with('error', 'Votre boutique est suspendue !');
        }

        return $next($request);
    }
}