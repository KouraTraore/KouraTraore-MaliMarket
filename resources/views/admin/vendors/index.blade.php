<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeurs - MaliMarket Admin</title>
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
        <a href="{{ route('admin.vendors.index') }}" class="active"><i class="fas fa-store"></i> Vendeurs</a>
        <a href="{{ route('admin.categories.index') }}"><i class="fas fa-th-large"></i> Catégories</a>
        <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Produits</a>
        <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-bag"></i> Commandes</a>
        <a href="{{ route('home') }}"><i class="fas fa-eye"></i> Voir la boutique</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-store me-2"></i>Vendeurs</h5>
        <span class="badge bg-success px-3 py-2">Admin</span>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- STATS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #1a5276, #2980b9);">
                    <p class="small mb-1 opacity-75">Total vendeurs</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e8449, #2ecc71);">
                    <p class="small mb-1 opacity-75">Approuvés</p>
                    <h3 class="fw-bold mb-0">{{ $stats['approuve'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <p class="small mb-1 opacity-75">En attente</p>
                    <h3 class="fw-bold mb-0">{{ $stats['en_attente'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #c0392b, #e74c3c);">
                    <p class="small mb-1 opacity-75">Suspendus</p>
                    <h3 class="fw-bold mb-0">{{ $stats['suspendu'] }}</h3>
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
                                <th class="ps-4 py-3">Boutique</th>
                                <th class="py-3">Propriétaire</th>
                                <th class="py-3">Téléphone</th>
                                <th class="py-3">Ville</th>
                                <th class="py-3">Statut</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($vendor->logo)
                                            <img src="{{ asset($vendor->logo) }}" class="rounded-circle"
                                                style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width:40px;height:40px;background:linear-gradient(135deg,#1a5276,#2ecc71);">
                                                <i class="fas fa-store text-white small"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="mb-0 fw-bold">{{ $vendor->nom_boutique }}</p>
                                            <small class="text-muted">{{ $vendor->description ? Str::limit($vendor->description, 30) : '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 fw-bold">{{ $vendor->user->name ?? '' }}</p>
                                    <small class="text-muted">{{ $vendor->user->email ?? '' }}</small>
                                </td>
                                <td>{{ $vendor->telephone }}</td>
                                <td>{{ $vendor->ville }}</td>
                                <td>
                                    @if($vendor->statut == 'approuve')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Approuvé</span>
                                    @elseif($vendor->statut == 'en_attente')
                                        <span class="badge bg-warning px-3 py-2 rounded-pill">En attente</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">Suspendu</span>
                                    @endif
                                </td>
                                <td>{{ $vendor->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        @if($vendor->statut != 'approuve')
                                        <form action="{{ route('admin.vendors.approve', $vendor->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                <i class="fas fa-check me-1"></i>Approuver
                                            </button>
                                        </form>
                                        @endif
                                        @if($vendor->statut != 'suspendu')
                                        <form action="{{ route('admin.vendors.suspend', $vendor->id) }}" method="POST"
                                            onsubmit="return confirm('Suspendre ce vendeur ?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                                <i class="fas fa-ban me-1"></i>Suspendre
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-store fa-3x mb-3 d-block"></i>
                                    Aucun vendeur
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $vendors->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>