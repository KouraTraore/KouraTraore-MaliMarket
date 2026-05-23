@extends('layouts.app')

@section('title', 'Mes Commandes - MaliMarket')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #1a5276;">
        <i class="fas fa-box me-2" style="color: #2ecc71;"></i>
        Mes Commandes
    </h2>

    @if($orders->count() > 0)
    <div class="row g-4">
        @foreach($orders as $order)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $order->numero }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $order->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->statutColor() }} px-3 py-2 rounded-pill mb-1 d-block">
                                {{ $order->statutLabel() }}
                            </span>
                            <span class="fw-bold" style="color: #1a5276;">
                                {{ number_format($order->montant_total, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>

                    <!-- PRODUITS -->
                    <div class="d-flex gap-3 flex-wrap mb-3">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center gap-2 bg-light rounded-3 p-2">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset($item->product->image) }}" class="rounded" style="width:40px;height:40px;object-fit:cover;">
                            @endif
                            <div>
                                <p class="mb-0 small fw-bold">{{ $item->product->nom ?? 'Produit supprimé' }}</p>
                                <small class="text-muted">Qté: {{ $item->quantite }} × {{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</small>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $order->ville_livraison }}
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-credit-card me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->mode_paiement)) }}
                            </span>
                        </div>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-mali btn-sm px-4">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-5x text-muted mb-4"></i>
        <h3 class="text-muted">Aucune commande pour le moment</h3>
        <p class="text-muted mb-4">Commencez vos achats sur MaliMarket !</p>
        <a href="{{ route('home') }}" class="btn btn-mali btn-lg px-5">
            <i class="fas fa-store me-2"></i>Découvrir les produits
        </a>
    </div>
    @endif
</div>
@endsection