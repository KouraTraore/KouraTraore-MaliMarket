<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Produits - MaliMarket</title>
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
        <a href="{{ route('vendor.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('vendor.products.index') }}" class="active"><i class="fas fa-box"></i> Mes Produits</a>
        <a href="{{ route('vendor.products.create') }}"><i class="fas fa-plus"></i> Ajouter un produit</a>
        <a href="{{ route('home') }}"><i class="fas fa-eye"></i> Voir la boutique</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-box me-2"></i>Mes Produits</h5>
        <a href="{{ route('vendor.products.create') }}" class="btn fw-bold text-white rounded-pill px-4"
            style="background: linear-gradient(135deg, #f39c12, #e67e22);">
            <i class="fas fa-plus me-2"></i>Ajouter un produit
        </a>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">Image</th>
                                <th class="py-3">Produit</th>
                                <th class="py-3">Catégorie</th>
                                <th class="py-3">Prix</th>
                                <th class="py-3">Stock</th>
                                <th class="py-3">Statut</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" class="rounded-3"
                                            style="width:50px;height:50px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                            style="width:50px;height:50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="mb-0 fw-bold">{{ $product->nom }}</p>
                                    <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                </td>
                                <td>{{ $product->category->nom ?? '-' }}</td>
                                <td class="fw-bold" style="color: #f39c12;">
                                    {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">Rupture</span>
                                    @elseif($product->stock < 5)
                                        <span class="badge bg-warning">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->statut == 'actif')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Actif</span>
                                    @elseif($product->statut == 'inactif')
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Inactif</span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2 rounded-pill">En attente</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('vendor.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('vendor.products.destroy', $product->id) }}"
                                            method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-box fa-3x mb-3 d-block"></i>
                                    Aucun produit encore
                                    <br>
                                    <a href="{{ route('vendor.products.create') }}"
                                        class="btn btn-warning btn-sm mt-3 rounded-pill px-4">
                                        Ajouter mon premier produit
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>