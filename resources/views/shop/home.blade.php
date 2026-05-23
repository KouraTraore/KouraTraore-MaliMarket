@extends('layouts.app')

@section('title', 'MaliMarket - La Marketplace du Mali')

@section('content')

<!-- HERO BANNER -->
<div style="background: linear-gradient(135deg, #1a5276 0%, #2ecc71 100%); padding: 80px 0; margin-bottom: 40px;">
    <div class="container text-center text-white">
        <h1 class="fw-bold mb-3" style="font-size: 3rem;">
            Bienvenue sur <span style="color: #f39c12;">MaliMarket</span> 🇲🇱
        </h1>
        <p class="fs-5 mb-4">La première marketplace du Mali — Achetez et vendez facilement !</p>
        <form action="{{ route('search') }}" method="GET" class="d-flex justify-content-center">
            <div class="input-group" style="max-width: 600px; border-radius: 30px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Que recherchez-vous ?">
                <button class="btn btn-warning btn-lg px-4 fw-bold" type="submit">
                    <i class="fas fa-search me-2"></i>Rechercher
                </button>
            </div>
        </form>
        <div class="mt-4 d-flex justify-content-center gap-4">
            <span><i class="fas fa-truck me-2"></i>Livraison rapide</span>
            <span><i class="fas fa-shield-alt me-2"></i>Paiement sécurisé</span>
            <span><i class="fas fa-store me-2"></i>Vendeurs vérifiés</span>
        </div>
    </div>
</div>

<div class="container">

    <!-- CATEGORIES -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #1a5276;">
                <i class="fas fa-th-large me-2" style="color: #2ecc71;"></i>
                Catégories
            </h2>
        </div>
        <div class="row g-3">
            @forelse($categories as $category)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center border-0 shadow-sm rounded-4 p-3 h-100" style="transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" class="rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #1a5276, #2ecc71);">
                                <i class="fas fa-tag text-white fs-4"></i>
                            </div>
                        @endif
                        <p class="mb-0 fw-600 small" style="color: #2c3e50;">{{ $category->nom }}</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center text-muted">Aucune catégorie disponible</div>
            @endforelse
        </div>
    </div>

    <!-- PRODUITS RECENTS -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #1a5276;">
                <i class="fas fa-star me-2" style="color: #f39c12;"></i>
                Nouveaux produits
            </h2>
            <a href="{{ route('search') }}" class="btn btn-outline-success rounded-pill">Voir tout</a>
        </div>
        <div class="row g-4">
            @forelse($produitsRecents as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->nom }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                                <i class="fas fa-image fa-3x text-secondary"></i>
                            </div>
                        @endif
                        @if($product->enPromo())
                            <span class="badge-promo">PROMO</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="vendor-name mb-1">
                            <i class="fas fa-store me-1"></i>{{ $product->vendor->nom_boutique ?? '' }}
                        </p>
                        <h6 class="fw-bold mb-2">{{ Str::limit($product->nom, 40) }}</h6>
                        <div class="mt-auto">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="prix">{{ number_format($product->prixFinal(), 0, ',', ' ') }} FCFA</span>
                                @if($product->enPromo())
                                    <span class="prix-barre">{{ number_format($product->prix, 0, ',', ' ') }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-mali btn-sm flex-fill">
                                    Voir
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="btn btn-cart btn-sm">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p>Aucun produit disponible pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- BANNIERE VENDEUR -->
    <div class="rounded-4 p-5 mb-5 text-white text-center" style="background: linear-gradient(135deg, #f39c12, #e74c3c);">
        <h3 class="fw-bold mb-3">Vous avez des produits à vendre ? 🛍️</h3>
        <p class="mb-4">Créez votre boutique gratuitement et vendez partout au Mali !</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold rounded-pill px-5">
            <i class="fas fa-store me-2"></i>Ouvrir ma boutique
        </a>
    </div>

    <!-- PRODUITS POPULAIRES -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #1a5276;">
                <i class="fas fa-fire me-2" style="color: #e74c3c;"></i>
                Produits populaires
            </h2>
            <a href="{{ route('search') }}" class="btn btn-outline-success rounded-pill">Voir tout</a>
        </div>
        <div class="row g-4">
            @forelse($produitsPopulaires as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->nom }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                                <i class="fas fa-image fa-3x text-secondary"></i>
                            </div>
                        @endif
                        @if($product->enPromo())
                            <span class="badge-promo">PROMO</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="vendor-name mb-1">
                            <i class="fas fa-store me-1"></i>{{ $product->vendor->nom_boutique ?? '' }}
                        </p>
                        <h6 class="fw-bold mb-2">{{ Str::limit($product->nom, 40) }}</h6>
                        <div class="mt-auto">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="prix">{{ number_format($product->prixFinal(), 0, ',', ' ') }} FCFA</span>
                                @if($product->enPromo())
                                    <span class="prix-barre">{{ number_format($product->prix, 0, ',', ' ') }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-mali btn-sm flex-fill">
                                    Voir
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="btn btn-cart btn-sm">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p>Aucun produit disponible pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection