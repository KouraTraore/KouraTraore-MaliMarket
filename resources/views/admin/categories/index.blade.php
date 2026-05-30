<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories - MaliMarket Admin</title>
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
        <a href="{{ route('admin.categories.index') }}" class="active"><i class="fas fa-th-large"></i> Catégories</a>
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
        <h5 class="mb-0 fw-bold"><i class="fas fa-th-large me-2"></i>Catégories</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn fw-bold text-white rounded-pill px-4"
            style="background: linear-gradient(135deg, #1a5276, #2ecc71);">
            <i class="fas fa-plus me-2"></i>Nouvelle catégorie
        </a>
    </div>

    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    @if($category->image)
                        <img src="{{ asset($category->image) }}" alt="{{ $category->nom }}"
                            style="height: 150px; object-fit: cover; width: 100%;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                            style="height: 150px;">
                            <i class="fas fa-th-large fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $category->nom }}</h6>
                        <p class="text-muted small mb-3">
                            {{ $category->products->count() }} produit(s)
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-outline-warning flex-fill rounded-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-th-large fa-3x mb-3 d-block"></i>
                Aucune catégorie
            </div>
            @endforelse
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>