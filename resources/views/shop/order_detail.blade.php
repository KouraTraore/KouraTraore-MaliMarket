@extends('layouts.app')

@section('title', 'Détail Commande - MaliMarket')

@section('content')
<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1a5276;">
                <i class="fas fa-box me-2" style="color: #2ecc71;"></i>
                Commande {{ $order->numero }}
            </h2>
            <small class="text-muted">
                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
            </small>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row g-4">
        <!-- PRODUITS -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold">Produits commandés</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center gap-3 p-4 border-bottom">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset($item->product->image) }}" class="rounded-3" style="width:70px;height:70px;object-fit:cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $item->product->nom ?? 'Produit supprimé' }}</h6>
                            <small class="text-muted">Quantité : {{ $item->quantite }}</small>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 text-muted small">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA × {{ $item->quantite }}</p>
                            <p class="mb-0 fw-bold" style="color: #1a5276;">{{ number_format($item->sous_total, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                    @endforeach

                    <!-- TOTAL -->
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Sous-total</span>
                            <span>{{ number_format($order->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Livraison</span>
                            <span class="text-success fw-bold">Gratuite</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5" style="color: #1a5276;">
                                {{ number_format($order->montant_total, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFOS -->
        <div class="col-lg-4">

            <!-- STATUT -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Statut de la commande</h5>

                    <!-- TIMELINE -->
                    <div class="position-relative">
                        @php
                            $statuts = ['en_attente', 'confirmee', 'en_livraison', 'livree'];
                            $currentIndex = array_search($order->statut, $statuts);
                        @endphp
                        @foreach($statuts as $index => $statut)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width:35px;height:35px;background:{{ $index <= $currentIndex ? '#2ecc71' : '#ecf0f1' }};flex-shrink:0;">
                                <i class="fas fa-check text-white small"></i>
                            </div>
                            <span class="{{ $index <= $currentIndex ? 'fw-bold' : 'text-muted' }}">
                                @if($statut == 'en_attente') En attente
                                @elseif($statut == 'confirmee') Confirmée
                                @elseif($statut == 'en_livraison') En livraison
                                @elseif($statut == 'livree') Livrée
                                @endif
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- LIVRAISON -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Informations de livraison</h5>
                    <p class="mb-1"><i class="fas fa-user me-2 text-muted"></i>{{ $order->nom_livraison }}</p>
                    <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i>{{ $order->telephone_livraison }}</p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $order->adresse_livraison }}</p>
                    <p class="mb-0"><i class="fas fa-city me-2 text-muted"></i>{{ $order->ville_livraison }}</p>
                </div>
            </div>

            <!-- PAIEMENT -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Paiement</h5>
                    <p class="mb-1">
                        <i class="fas fa-credit-card me-2 text-muted"></i>
                        {{ ucfirst(str_replace('_', ' ', $order->mode_paiement)) }}
                    </p>
                    <p class="mb-0">
                        @if($order->statut_paiement == 'paye')
                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                <i class="fas fa-check me-1"></i>Payé
                            </span>
                        @else
                            <span class="badge bg-warning px-3 py-2 rounded-pill">
                                <i class="fas fa-clock me-1"></i>En attente de paiement
                            </span>
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection