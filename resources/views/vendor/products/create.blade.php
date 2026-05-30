<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Produit - MaliMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar { width: 260px; min-height: 100vh; background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar-brand h4 { color: white; font-weight: 700; margin: 0; }
        .sidebar-brand small { color: rgba(255,255,255,0.7); }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.85); text-decoration: none; padding: 12px 20px; font-size: 0.9rem; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.15); color: white; border-left: 3px solid white; }
        .main-content { margin-left: 260px; min-height: 100vh; background: #f0f2f5; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .content-area { padding: 30px; }
        .upload-zone { border: 2px dashed #dee2e6; border-radius: 10px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s; }
        .upload-zone:hover { border-color: #f39c12; background: #fff8f0; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>🛍️ Ma Boutique</h4>
        <small>Vendeur MaliMarket</small>
    </div>
    <div class="sidebar-menu pt-3">
        <a href="{{ route('vendor.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('vendor.products.index') }}"><i class="fas fa-box"></i> Mes Produits</a>
        <a href="{{ route('vendor.products.create') }}" class="active"><i class="fas fa-plus"></i> Ajouter un produit</a>
        <a href="{{ route('home') }}"><i class="fas fa-eye"></i> Voir la boutique</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>
</div>
<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus me-2"></i>Ajouter un produit</h5>
        <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left me-2"></i>Retour</a>
    </div>
    <div class="content-area">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">{{ $errors->first() }}</div>
                        @endif
                        <div class="alert alert-info rounded-3 mb-4">
                            <i class="fas fa-info-circle me-2"></i>Votre produit sera visible après validation par l'administrateur.
                        </div>
                        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nom du produit</label>
                                    <input type="text" name="nom" class="form-control rounded-3" placeholder="Ex: Boubou brodé homme" value="{{ old('nom') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix (FCFA)</label>
                                    <input type="number" name="prix" class="form-control rounded-3" placeholder="Ex: 45000" value="{{ old('prix') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix promo (optionnel)</label>
                                    <input type="number" name="prix_promo" class="form-control rounded-3" placeholder="Ex: 38000" value="{{ old('prix_promo') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Stock disponible</label>
                                    <input type="number" name="stock" class="form-control rounded-3" placeholder="Ex: 20" value="{{ old('stock', 1) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Catégorie</label>
                                    <select name="category_id" class="form-select rounded-3" required>
                                        <option value="">-- Choisir une catégorie --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- IMAGE -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Image du produit</label>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">📁 Télécharger une image depuis votre ordinateur</label>
                                        <input type="file" name="image_file" class="form-control rounded-3" accept="image/*" onchange="previewUpload(this)">
                                        <small class="text-muted">JPG, PNG, GIF, WEBP (max 2MB)</small>
                                    </div>
                                    <div class="text-center text-muted my-2 fw-bold">— OU —</div>
                                    <div>
                                        <label class="form-label text-muted small">🔗 URL d'une image internet</label>
                                        <input type="url" name="image" class="form-control rounded-3" placeholder="https://images.unsplash.com/..." value="{{ old('image') }}" oninput="previewImage(this.value)">
                                    </div>
                                    <div id="imagePreview" class="mt-3" style="display:none;">
                                        <img id="previewImg" src="" class="rounded-3" style="height: 200px; object-fit: cover;">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Décrivez votre produit en détail...">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn w-100 py-3 fw-bold text-white rounded-3" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                                        <i class="fas fa-save me-2"></i>Ajouter le produit
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
function previewUpload(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>