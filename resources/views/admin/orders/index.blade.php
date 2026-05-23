<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes - MaliMarket Admin</title>
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
            top: 0; left: 0;
            z-index: 100;
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
        .topbar {
            background: white; padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .content-area { padding: 30px; }
        .stat-card { border: none; border-radius: 15px; padding: 20px; color: white; }
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
        <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag me-2"></i>Commandes</h5>
        <span class="badge bg-success">Admin</span>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- STATS -->
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #1a5276, #2980b9);">
                    <p class="small mb-1 opacity-75">Total</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <p class="small mb-1 opacity-75">En attente</p>
                    <h3 class="fw-bold mb-0">{{ $stats['en_attente'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #2980b9, #3498db);">
                    <p class="small mb-1 opacity-75">En livraison</p>
                    <h3 class="fw-bold mb-0">{{ $stats['en_livraison'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e8449, #2ecc71);">
                    <p class="small mb-1 opacity-75">Livrées</p>
                    <h3 class="fw-bold mb-0">{{ $stats['livrees'] }}</h3>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #c0392b, #e74c3c);">
                    <p class="small mb-1 opacity-75">Annulées</p>
                    <h3 class="fw-bold mb-0">{{ $stats['annulees'] }}</h3>
                </div>
            </div>
        </div>

        <!-- TABLEAU -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">N° Commande</th>
                                <th class="py-3">Client</th>
                                <th class="py-3">Montant</th>
                                <th class="py-3">Ville</th>
                                <th class="py-3">Paiement</th>
                                <th class="py-3">Statut</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $order->numero }}</td>
                                <td>
                                    <p class="mb-0 fw-bold">{{ $order->user->name ?? '' }}</p>
                                    <small class="text-muted">{{ $order->telephone_livraison }}</small>
                                </td>
                                <td class="fw-bold" style="color: #1a5276;">
                                    {{ number_format($order->montant_total, 0, ',', ' ') }} FCFA
                                </td>
                                <td>{{ $order->ville_livraison }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ ucfirst(str_replace('_', ' ', $order->mode_paiement)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->statutColor() }} px-3 py-2 rounded-pill">
                                        {{ $order->statutLabel() }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i>Voir
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-shopping-bag fa-3x mb-3 d-block"></i>
                                    Aucune commande
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>