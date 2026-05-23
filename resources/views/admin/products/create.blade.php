<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Produit - MaliMarket Admin</title>
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
        <a href="{{ route('admin.products.index') }}" class="active"><i class="fas fa-box"></i> Produits</a>
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
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus me-2"></i>Nouveau Produit</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="content-area">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form action="{{ route('admin.products.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nom du produit</label>
                                    <input type="text" name="nom" class="form-control rounded-3"
                                        placeholder="Ex: Samsung Galaxy A54" value="{{ old('nom') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix (FCFA)</label>
                                    <input type="number" name="prix" class="form-control rounded-3"
                                        placeholder="Ex: 285000" value="{{ old('prix') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix promo (optionnel)</label>
                                    <input type="number" name="prix_promo" class="form-control rounded-3"
                                        placeholder="Ex: 265000" value="{{ old('prix_promo') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Stock</label>
                                    <input type="number" name="stock" class="form-control rounded-3"
                                        placeholder="Ex: 10" value="{{ old('stock', 0) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Statut</label>
                                    <select name="statut" class="form-select rounded-3">
                                        <option value="actif">Actif</option>
                                        <option value="inactif">Inactif</option>
                                        <option value="en_attente">En attente</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Catégorie</label>
                                    <select name="category_id" class="form-select rounded-3" required>
                                        <option value="">-- Choisir --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Vendeur</label>
                                    <select name="vendor_id" class="form-select rounded-3" required>
                                        <option value="">-- Choisir --</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->nom_boutique }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">URL de l'image</label>
                                    <input type="url" name="image" class="form-control rounded-3"
                                        placeholder="https://images.unsplash.com/..."
                                        value="{{ old('image') }}"
                                        oninput="previewImage(this.value)">
                                    <div id="imagePreview" class="mt-3" style="display:none;">
                                        <img id="previewImg" src="" class="rounded-3"
                                            style="height: 200px; object-fit: cover;">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control rounded-3" rows="4"
                                        placeholder="Description du produit...">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn w-100 py-3 fw-bold text-white rounded-3"
                                        style="background: linear-gradient(135deg, #1a5276, #2ecc71);">
                                        <i class="fas fa-save me-2"></i>Créer le produit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImage(url) {
    if (url) {
        document.getElementById('previewImg').src = url;
        document.getElementById('imagePreview').style.display = 'block';
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
}
</script>
</body>
</html>