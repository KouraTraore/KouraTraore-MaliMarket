<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Commande - MaliMarket Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar {
            width: 260px; min-height: 100vh;
            background: linear-gradient(180deg, #1a5276 0%, #154360 100%);
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand { padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h4 { color: white; font-weight: 700; margin: 0; }
        .sidebar-brand span { color: #2ecc71; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.8); text-decoration: none;
            padding: 12px 20px; font-size: 0.9rem; transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.1); color: white;
            border-left: 3px solid #2ecc71;
        }
        .main-content { margin-left: 260px; min-height: 100vh; background: #f0f2f5; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .content-area { padding: 30px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>Mali<span>Market</span> 🇲🇱</h4>
        <small style="color: rgba(255,255,255,0.5);">Administration</small>
    </div>
    <div class="sidebar-menu pt-3">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('admin.vendors.index') }}"><i class="fas fa-store"></i> Vendeurs</a>
        <a href="{{ route('admin.categories.index') }}"><i class="fas fa-th-large"></i> Catégories</a>
        <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Produits</a>
        <a href="{{ route('admin.orders.index') }}" class="active"><i class="fas fa-shopping-bag"></i> Commandes</a>
        <a href="{{ route('home') }}"><i class="fas fa-eye"></i> Voir la boutique</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Commande {{ $order->numero }}</h5>
            <small class="text-muted">{{ $order->created_at->format('d/m/Y à H:i') }}</small>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

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
                                <small class="text-muted">
                                    Boutique : {{ $item->vendor->nom_boutique ?? '' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <p class="mb-0 text-muted small">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA × {{ $item->quantite }}</p>
                                <p class="mb-0 fw-bold" style="color: #1a5276;">{{ number_format($item->sous_total, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                        @endforeach

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

                <!-- CHANGER STATUT -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Changer le statut</h5>
                        <div class="mb-3">
                            <span class="badge bg-{{ $order->statutColor() }} px-3 py-2 rounded-pill fs-6">
                                {{ $order->statutLabel() }}
                            </span>
                        </div>
                        <form action="{{ route('admin.orders.statut', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="statut" class="form-select rounded-3 mb-3">
                                <option value="en_attente" {{ $order->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmee" {{ $order->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                                <option value="en_livraison" {{ $order->statut == 'en_livraison' ? 'selected' : '' }}>En livraison</option>
                                <option value="livree" {{ $order->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ $order->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            <button type="submit" class="btn w-100 py-2 fw-bold text-white rounded-3"
                                style="background: linear-gradient(135deg, #1a5276, #2ecc71);">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </form>
                    </div>
                </div>

                <!-- CLIENT -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Client</h5>
                        <p class="mb-1"><i class="fas fa-user me-2 text-muted"></i>{{ $order->user->name ?? '' }}</p>
                        <p class="mb-1"><i class="fas fa-envelope me-2 text-muted"></i>{{ $order->user->email ?? '' }}</p>
                        <p class="mb-0"><i class="fas fa-phone me-2 text-muted"></i>{{ $order->user->telephone ?? '' }}</p>
                    </div>
                </div>

                <!-- LIVRAISON -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Livraison</h5>
                        <p class="mb-1"><i class="fas fa-user me-2 text-muted"></i>{{ $order->nom_livraison }}</p>
                        <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i>{{ $order->telephone_livraison }}</p>
                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $order->adresse_livraison }}</p>
                        <p class="mb-0"><i class="fas fa-city me-2 text-muted"></i>{{ $order->ville_livraison }}</p>
                        @if($order->notes)
                        <hr>
                        <p class="mb-0 text-muted small"><i class="fas fa-sticky-note me-2"></i>{{ $order->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>