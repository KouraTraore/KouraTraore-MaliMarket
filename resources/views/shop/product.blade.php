@extends('layouts.app')

@section('title', $product->nom . ' - MaliMarket')

@section('content')
<div class="container py-5">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug ?? '') }}">{{ $product->category->nom ?? '' }}</a></li>
            <li class="breadcrumb-item active">{{ $product->nom }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- IMAGE -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->nom }}" class="w-100" style="height: 400px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-secondary"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- DETAILS -->
        <div class="col-lg-7">
            <p class="text-muted mb-2">
                <i class="fas fa-store me-1"></i>
                <a href="#" style="color: #2ecc71;">{{ $product->vendor->nom_boutique ?? '' }}</a>
            </p>
            <h1 class="fw-bold mb-3" style="color: #1a5276;">{{ $product->nom }}</h1>

            <!-- NOTE MOYENNE -->
            @if($product->reviews->count() > 0)
            <div class="mb-3">
                <span class="fs-5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($product->noteMoyenne()))
                            ⭐
                        @else
                            ☆
                        @endif
                    @endfor
                </span>
                <span class="text-muted ms-2">{{ $product->noteMoyenne() }}/5 ({{ $product->reviews->count() }} avis)</span>
            </div>
            @endif

            <!-- PRIX -->
            <div class="mb-4">
                <span class="fs-2 fw-bold" style="color: #1a5276;">
                    {{ number_format($product->prixFinal(), 0, ',', ' ') }} FCFA
                </span>
                @if($product->enPromo())
                    <span class="text-muted text-decoration-line-through ms-3 fs-5">
                        {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                    </span>
                    <span class="badge bg-danger ms-2">PROMO</span>
                @endif
            </div>

            <!-- STOCK -->
            <div class="mb-4">
                @if($product->enStock())
                    <span class="badge bg-success px-3 py-2 rounded-pill">
                        <i class="fas fa-check me-1"></i> En stock ({{ $product->stock }} disponibles)
                    </span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                        <i class="fas fa-times me-1"></i> Rupture de stock
                    </span>
                @endif
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">
                <h5 class="fw-bold">Description</h5>
                <p class="text-muted">{{ $product->description ?? 'Aucune description disponible.' }}</p>
            </div>

            <!-- AJOUTER AU PANIER -->
            @if($product->enStock())
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex gap-3 align-items-center mb-3">
                    <div class="input-group" style="width: 130px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decrementQty()">-</button>
                        <input type="number" name="quantite" id="quantite" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="incrementQty()">+</button>
                    </div>
                    <button type="submit" class="btn btn-cart btn-lg px-5">
                        <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                    </button>
                </div>
            </form>
            @endif

            <!-- INFOS LIVRAISON -->
            <div class="card border-0 bg-light rounded-4 p-3 mt-3">
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <i class="fas fa-truck fa-2x mb-2" style="color: #2ecc71;"></i>
                        <p class="mb-0 small fw-bold">Livraison rapide</p>
                        <small class="text-muted">Bamako & Mali</small>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-shield-alt fa-2x mb-2" style="color: #1a5276;"></i>
                        <p class="mb-0 small fw-bold">Paiement sécurisé</p>
                        <small class="text-muted">Orange Money</small>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-undo fa-2x mb-2" style="color: #f39c12;"></i>
                        <p class="mb-0 small fw-bold">Retour facile</p>
                        <small class="text-muted">7 jours</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AVIS CLIENTS -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4" style="color: #1a5276;">
                <i class="fas fa-star me-2" style="color: #f39c12;"></i>
                Avis clients
                @if($product->reviews->count() > 0)
                    <span class="badge bg-warning text-dark ms-2">
                        {{ $product->noteMoyenne() }}/5 ({{ $product->reviews->count() }} avis)
                    </span>
                @endif
            </h3>

            <!-- FORMULAIRE AVIS -->
            @auth
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Laisser un avis</h5>
                    <form action="{{ route('review.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Note</label>
                            <div class="d-flex gap-3 flex-wrap">
                                @for($i = 1; $i <= 5; $i++)
                                <div class="form-check">
                                    <input type="radio" name="note" value="{{ $i }}"
                                        id="note{{ $i }}" class="form-check-input"
                                        {{ old('note') == $i ? 'checked' : '' }}>
                                    <label for="note{{ $i }}" class="form-check-label fs-5">
                                        {{ str_repeat('⭐', $i) }}
                                    </label>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Commentaire (optionnel)</label>
                            <textarea name="commentaire" class="form-control rounded-3" rows="3"
                                placeholder="Partagez votre expérience...">{{ old('commentaire') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-mali rounded-pill px-4">
                            <i class="fas fa-paper-plane me-2"></i>Publier mon avis
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-info rounded-3 mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <a href="{{ route('login') }}" class="fw-bold">Connectez-vous</a> pour laisser un avis !
            </div>
            @endauth

            <!-- LISTE DES AVIS -->
            @forelse($product->reviews()->with('user')->latest()->get() as $review)
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                style="width:45px;height:45px;background:linear-gradient(135deg,#1a5276,#2ecc71);flex-shrink:0;">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">{{ $review->user->name }}</p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-5">{{ $review->etoiles() }}</span>
                            @auth
                                @if(Auth::id() == $review->user_id)
                                <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                        onclick="return confirm('Supprimer cet avis ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    @if($review->commentaire)
                    <p class="mb-0 text-muted mt-2">{{ $review->commentaire }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <i class="fas fa-star fa-3x mb-3 d-block opacity-25"></i>
                <p>Aucun avis pour ce produit encore. Soyez le premier ! ⭐</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- PRODUITS SIMILAIRES -->
    @if($produitsSimiliaires->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4" style="color: #1a5276;">
            <i class="fas fa-th me-2" style="color: #2ecc71;"></i>
            Produits similaires
        </h3>
        <div class="row g-4">
            @foreach($produitsSimiliaires as $p)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($p->image)
                            <img src="{{ $p->image }}" alt="{{ $p->nom }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                                <i class="fas fa-image fa-3x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold">{{ Str::limit($p->nom, 40) }}</h6>
                        <p class="prix">{{ number_format($p->prixFinal(), 0, ',', ' ') }} FCFA</p>
                        <a href="{{ route('product.show', $p->slug) }}" class="btn btn-mali btn-sm w-100">Voir</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
function incrementQty() {
    const input = document.getElementById('quantite');
    const max = parseInt(input.getAttribute('max'));
    if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
}
function decrementQty() {
    const input = document.getElementById('quantite');
    if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
}
</script>
@endpush

@endsection