<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MaliMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a5276 0%, #154360 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 3px 0 15px rgba(0,0,0,0.2);
        }
        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            margin: 0;
        }
        .sidebar-brand span { color: #2ecc71; }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu .menu-title {
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px 5px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 12px 20px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid #2ecc71;
        }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #f0f2f5;
        }
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .stat-card .icon {
            font-size: 3rem;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        .stat-card h3 { font-size: 2rem; font-weight: 700; }
        .stat-card p { margin: 0; opacity: 0.9; font-size: 0.9rem; }
        .card-ventes { background: linear-gradient(135deg, #1a5276, #2980b9); }
        .card-commandes { background: linear-gradient(135deg, #1e8449, #2ecc71); }
        .card-clients { background: linear-gradient(135deg, #7d6608, #f39c12); }
        .card-vendeurs { background: linear-gradient(135deg, #6c3483, #9b59b6); }
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
    <div class="sidebar-menu">
        <div class="menu-title">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="active">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.vendors.index') }}">
            <i class="fas fa-store"></i> Vendeurs
            @if($vendeursEnAttente > 0)
                <span class="badge bg-warning ms-auto">{{ $vendeursEnAttente }}</span>
            @endif
        </a>
        <a href="{{ route('admin.categories.index') }}">
            <i class="fas fa-th-large"></i> Catégories
        </a>
        <a href="{{ route('admin.products.index') }}">
            <i class="fas fa-box"></i> Produits
        </a>
        <a href="{{ route('admin.orders.index') }}">
            <i class="fas fa-shopping-bag"></i> Commandes
            @if($commandesEnAttente > 0)
                <span class="badge bg-danger ms-auto">{{ $commandesEnAttente }}</span>
            @endif
        </a>

        <div class="menu-title mt-3">Compte</div>
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
    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <h5 class="mb-0 fw-bold">Dashboard</h5>
            <small class="text-muted">Bienvenue, {{ auth()->user()->name }} 👋</small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-success">Admin</span>
            <span class="text-muted small">{{ now()->format('d/m/Y') }}</span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-area">

        <!-- STATS -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card card-ventes">
                    <i class="fas fa-chart-line icon"></i>
                    <p>Chiffre d'affaires</p>
                    <h3>{{ number_format($totalVentes, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card-commandes">
                    <i class="fas fa-shopping-bag icon"></i>
                    <p>Total commandes</p>
                    <h3>{{ $totalCommandes }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card-clients">
                    <i class="fas fa-users icon"></i>
                    <p>Total clients</p>
                    <h3>{{ $totalClients }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card-vendeurs">
                    <i class="fas fa-store icon"></i>
                    <p>Vendeurs actifs</p>
                    <h3>{{ $totalVendeurs }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- GRAPHIQUE -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Évolution des ventes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ventesChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- VENDEURS EN ATTENTE -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            Vendeurs en attente
                            <span class="badge bg-warning">{{ $vendeursEnAttente }}</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($vendeursAttente as $vendor)
                            <li class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $vendor->nom_boutique }}</p>
                                        <small class="text-muted">{{ $vendor->user->name ?? '' }}</small>
                                    </div>
                                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-sm btn-warning rounded-pill">
                                        Voir
                                    </a>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">
                                Aucun vendeur en attente
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- TOP PRODUITS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Top produits vendus</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($topProduits as $produit)
                            <li class="list-group-item px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($produit->image)
                                        <img src="{{ asset($produit->image) }}" class="rounded" style="width:45px;height:45px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-bold">{{ $produit->nom }}</p>
                                        <small class="text-muted">{{ $produit->total_vendus }} vendu(s)</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">Aucune vente</li>
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
                                        <p class="mb-0 fw-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</p>
                                        <span class="badge bg-{{ $commande->statutColor() }}">{{ $commande->statutLabel() }}</span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">Aucune commande</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- LOGOUT FORM -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ventesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($moisLabels) !!},
        datasets: [{
            label: 'Ventes (FCFA)',
            data: {!! json_encode($moisData) !!},
            borderColor: '#2ecc71',
            backgroundColor: 'rgba(46,204,113,0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#1a5276',
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: value => value.toLocaleString('fr-FR') + ' FCFA' }
            }
        }
    }
});
</script>

</body>
</html>