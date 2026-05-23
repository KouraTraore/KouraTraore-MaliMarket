@extends('layouts.app')

@section('title', 'Mon Panier - MaliMarket')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #1a5276;">
        <i class="fas fa-shopping-cart me-2" style="color: #2ecc71;"></i>
        Mon Panier
    </h2>

    @if(count($cart) > 0)
    <div class="row g-4">
        <!-- ARTICLES -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    @foreach($cart as $id => $item)
                    <div class="d-flex align-items-center gap-3 p-4 border-bottom">
                        <!-- IMAGE -->
                        <div style="width: 80px; flex-shrink: 0;">
                            @if($item['image'])
                                <img src="{{ asset($item['image']) }}" class="rounded-3 w-100" style="height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <!-- DETAILS -->
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $item['nom'] }}</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-store me-1"></i>
                            </p>
                            <span class="fw-bold" style="color: #1a5276;">
                                {{ number_format($item['prix'], 0, ',', ' ') }} FCFA
                            </span>
                        </div>

                        <!-- QUANTITE -->
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <div class="input-group" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.nextElementSibling.stepDown(); this.form.submit()">-</button>
                                <input type="number" name="quantite" value="{{ $item['quantite'] }}" min="1" class="form-control form-control-sm text-center" onchange="this.form.submit()">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.previousElementSibling.stepUp(); this.form.submit()">+</button>
                            </div>
                        </form>

                        <!-- SOUS TOTAL -->
                        <div class="text-end" style="min-width: 100px;">
                            <p class="fw-bold mb-0" style="color: #1a5276;">
                                {{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA
                            </p>
                        </div>

                        <!-- SUPPRIMER -->
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" style="width: 35px; height: 35px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RESUME -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Résumé de la commande</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total</span>
                        <span class="fw-bold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Livraison</span>
                        <span class="text-success fw-bold">Gratuite</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5" style="color: #1a5276;">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>

                    @auth
                        <a href="{{ route('checkout') }}" class="btn btn-mali w-100 py-3 fs-6">
                            <i class="fas fa-credit-card me-2"></i>Commander
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-mali w-100 py-3 fs-6">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter pour commander
                        </a>
                    @endauth

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                    </a>

                    <!-- MODES DE PAIEMENT -->
                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-2">Modes de paiement acceptés</p>
                        <div class="d-flex justify-content-center gap-3">
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-mobile-alt me-1"></i>Orange Money
                            </span>
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-mobile-alt me-1"></i>Moov Money
                            </span>
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="fas fa-truck me-1"></i>Livraison
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- PANIER VIDE -->
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
        <h3 class="text-muted">Votre panier est vide</h3>
        <p class="text-muted mb-4">Découvrez nos produits et ajoutez-les à votre panier !</p>
        <a href="{{ route('home') }}" class="btn btn-mali btn-lg px-5">
            <i class="fas fa-store me-2"></i>Découvrir les produits
        </a>
    </div>
    @endif
</div>
@endsection