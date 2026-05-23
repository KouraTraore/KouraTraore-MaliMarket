<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendeur - MaliMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar {
            width: 260px; min-height: 100vh;
            background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%);
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand { padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar-brand h4 { color: white; font-weight: 700; margin: 0; }
        .sidebar-brand small { color: rgba(255,255,255,0.7); }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.85); text-decoration: none;
            padding: 12px 20px; font-size: 0.9rem; transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.15); color: white;
            border-left: 3px solid white;
        }
        .main-content { margin-left: 260px; min-height: 100vh; background: #f0f2f5; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .content-area { padding: 30px; }
        .stat-card { border: none; border-radius: 15px; padding: 25px; color: white; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>🛍️ Ma Boutique</h4>
        <small>{{ $vendor->nom_boutique }}</small>
    </div>
    <div class="sidebar-menu pt-3">
        <a href="{{ route('vendor.dashboard') }}" class="active">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('vendor.products.index') }}">
            <i class="fas fa-box"></i> Mes Produits
        </a>
        <a href="{{ route('vendor.products.create') }}">
            <i class="fas fa-plus"></i> Ajouter un produit
        </a>
        <a href="{{ route('home') }}">
            <i class="fas fa-eye"></i> Voir la boutique
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Dashboard Vendeur</h5>
            <small class="text-muted">Bienvenue, {{ auth()->user()->name }} 👋</small>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if($vendor->statut == 'approuve')
                <span class="badge bg-success px-3 py-2">✅ Boutique approuvée</span>
            @elseif($vendor->statut == 'en_attente')
                <span class="badge bg-warning px-3 py-2">⏳ En attente d'approbation</span>
            @else
                <span class="badge bg-danger px-3 py-2">❌ Boutique suspendue</span>
            @endif
        </div>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- STATS -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <i class="fas fa-box fa-2x mb-3 opacity-75"></i>
                    <h3 class="fw-bold mb-1">{{ $totalProduits }}</h3>
                    <p class="mb-0 opacity-75">Mes produits</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #1a5276, #2980b9);">
                    <i class="fas fa-shopping-bag fa-2x mb-3 opacity-75"></i>
                    <h3 class="fw-bold mb-1">{{ $totalCommandes }}</h3>
                    <p class="mb-0 opacity-75">Commandes reçues</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e8449, #2ecc71);">
                    <i class="fas fa-chart-line fa-2x mb-3 opacity-75"></i>
                    <h3 class="fw-bold mb-1">{{ number_format($totalVentes, 0, ',', ' ') }} FCFA</h3>
                    <p class="mb-0 opacity-75">Total des ventes</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- TOP PRODUITS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                        <h5 class="fw-bold mb-0">Mes top produits</h5>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">
                            Voir tout
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($topProduits as $produit)
                            <li class="list-group-item px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($produit->image)
                                        <img src="{{ $produit->image }}" class="rounded-3"
                                            style="width:45px;height:45px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                            style="width:45px;height:45px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-bold">{{ $produit->nom }}</p>
                                        <small class="text-muted">{{ $produit->total_vendus }} vendu(s)</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-bold" style="color: #f39c12;">
                                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                        </p>
                                        <small class="badge bg-{{ $produit->stock > 0 ? 'success' : 'danger' }}">
                                            Stock: {{ $produit->stock }}
                                        </small>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">
                                <i class="fas fa-box fa-2x mb-2 d-block"></i>
                                Aucun produit encore
                                <br>
                                <a href="{{ route('vendor.products.create') }}" class="btn btn-warning btn-sm mt-2 rounded-pill">
                                    Ajouter un produit
                                </a>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DERNIERES COMMANDES -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Dernières commandes</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($dernieresCommandes as $commande)
                            <li class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $commande->numero }}</p>
                                        <small class="text-muted">{{ $commande->user->name ?? '' }}</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-bold" style="color: #1a5276;">
                                            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                        </p>
                                        <span class="badge bg-{{ $commande->statutColor() }}">
                                            {{ $commande->statutLabel() }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">
                                <i class="fas fa-shopping-bag fa-2x mb-2 d-block"></i>
                                Aucune commande encore
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFOS BOUTIQUE -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Informations de ma boutique</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Nom</p>
                        <p class="fw-bold">{{ $vendor->nom_boutique }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Téléphone</p>
                        <p class="fw-bold">{{ $vendor->telephone ?? '-' }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Ville</p>
                        <p class="fw-bold">{{ $vendor->ville }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Commission</p>
                        <p class="fw-bold">{{ $vendor->commission }}%</p>
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