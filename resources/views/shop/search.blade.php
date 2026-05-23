@extends('layouts.app')

@section('title', 'Recherche - MaliMarket')

@section('content')
<div class="container py-5">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold" style="color: #1a5276;">
            <i class="fas fa-search me-2" style="color: #2ecc71;"></i>
            Résultats pour : "{{ $query }}"
        </h2>
        <p class="text-muted">{{ $products->total() }} produit(s) trouvé(s)</p>
    </div>

    <!-- SEARCH BAR -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-lg border-0"
                        placeholder="Rechercher un produit..." value="{{ $query }}">
                    <button class="btn btn-lg px-4 fw-bold text-white"
                        style="background: linear-gradient(135deg, #1a5276, #2ecc71);">
                        <i class="fas fa-search me-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- PRODUITS -->
    @if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
                <div class="position-relative">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->nom }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                            style="height: 220px;">
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
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->appends(['q' => $query])->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="text-center py-5">
        <i class="fas fa-search fa-5x text-muted mb-4"></i>
        <h3 class="text-muted">Aucun produit trouvé</h3>
        <p class="text-muted mb-4">Essayez avec d'autres mots clés</p>
        <a href="{{ route('home') }}" class="btn btn-mali btn-lg px-5">
            <i class="fas fa-home me-2"></i>Retour à l'accueil
        </a>
    </div>
    @endif

</div>
@endsection