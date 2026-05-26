<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MaliMarket - La Marketplace du Mali')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        /* NAVBAR */
        .navbar-main {
            background: linear-gradient(135deg, #1a5276 0%, #2ecc71 100%);
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }
        .navbar-brand img { height: 45px; }
        .navbar-brand span {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
        }
        .navbar-brand span span { color: #f39c12; }

        /* SEARCH BAR */
        .search-form {
            flex: 1;
            max-width: 500px;
            margin: 0 20px;
        }
        .search-form .input-group {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .search-form input {
            border: none;
            padding: 10px 20px;
            font-size: 0.95rem;
        }
        .search-form button {
            background: #f39c12;
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: 600;
        }
        .search-form button:hover { background: #e67e22; }

        /* NAVBAR ICONS */
        .nav-icon {
            color: white !important;
            font-size: 1.3rem;
            position: relative;
            margin: 0 8px;
            text-decoration: none;
        }
        .nav-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            font-size: 0.65rem;
            padding: 3px 6px;
        }

        /* TOP BAR */
        .top-bar {
            background: #1a5276;
            color: #bdc3c7;
            font-size: 0.8rem;
            padding: 5px 0;
        }
        .top-bar a { color: #bdc3c7; text-decoration: none; }
        .top-bar a:hover { color: white; }

        /* CATEGORIES NAV */
        .categories-nav {
            background: white;
            border-bottom: 1px solid #ecf0f1;
            padding: 8px 0;
        }
        .categories-nav a {
            color: #2c3e50;
            text-decoration: none;
            padding: 5px 15px;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 20px;
            transition: all 0.3s;
        }
        .categories-nav a:hover {
            background: #2ecc71;
            color: white;
        }

        /* FOOTER */
        .footer-main {
            background: #1a252f;
            color: #bdc3c7;
            padding: 50px 0 20px;
            margin-top: 60px;
        }
        .footer-main h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .footer-main a {
            color: #bdc3c7;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .footer-main a:hover { color: #2ecc71; }
        .footer-bottom {
            border-top: 1px solid #2c3e50;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            font-size: 0.85rem;
        }

        /* BOUTONS */
        .btn-mali {
            background: linear-gradient(135deg, #1a5276, #2ecc71);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-mali:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,204,113,0.4);
            color: white;
        }
        .btn-cart {
            background: #f39c12;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-cart:hover {
            background: #e67e22;
            transform: translateY(-2px);
            color: white;
        }

        /* CARDS PRODUITS */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .product-card img {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }
        .product-card .badge-promo {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e74c3c;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .product-card .prix {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a5276;
        }
        .product-card .prix-barre {
            text-decoration: line-through;
            color: #bdc3c7;
            font-size: 0.9rem;
        }
        .product-card .vendor-name {
            font-size: 0.8rem;
            color: #7f8c8d;
        }
    </style>

    @stack('styles')
</head>
<body style="background: #f8f9fa;">

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-map-marker-alt me-1"></i> Livraison à Bamako et partout au Mali</span>
            <div>
                <a href="#"><i class="fas fa-phone me-1"></i>+223 90 85 93 91 </a>
                <span class="mx-2">|</span>
                <a href="#"><i class="fas fa-envelope me-1"></i> contact@malimarket.ml</a>
            </div>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar-main">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="navbar-brand text-decoration-none">
                <span>Mali<span>Market</span></span>
            </a>

            <!-- SEARCH -->
            <form class="search-form d-none d-md-flex" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Rechercher un produit..." value="{{ request('q') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <!-- ICONS -->
            <div class="d-flex align-items-center">
                @guest
                    <a href="{{ route('login') }}" class="nav-icon" title="Connexion">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm ms-2 fw-bold">
                        S'inscrire
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#" class="nav-icon dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text fw-bold">{{ auth()->user()->name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Admin</a></li>
                            @elseif(auth()->user()->isVendeur())
                                <li><a class="dropdown-item" href="{{ route('vendor.dashboard') }}"><i class="fas fa-store me-2"></i>Ma boutique</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box me-2"></i>Mes commandes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest

                <a href="{{ route('cart.index') }}" class="nav-icon ms-3" title="Panier">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="badge rounded-pill">{{ count(session('cart')) }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- CATEGORIES NAV -->
<div class="categories-nav">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Accueil</a>
            @foreach(\App\Models\Category::where('active', true)->take(8)->get() as $cat)
                <a href="{{ route('category.show', $cat->slug) }}">{{ $cat->nom }}</a>
            @endforeach
        </div>
    </div>
</div>

<!-- FLASH MESSAGES -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- CONTENU -->
@yield('content')

<!-- FOOTER -->
<footer class="footer-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5>MaliMarket 🇲🇱</h5>
                <p class="small">La première marketplace du Mali. Achetez et vendez facilement partout au Mali.</p>
            </div>
            <div class="col-lg-2 mb-4">
                <h5>Acheter</h5>
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('search') }}">Recherche</a>
                <a href="{{ route('cart.index') }}">Panier</a>
            </div>
            <div class="col-lg-2 mb-4">
                <h5>Vendre</h5>
                <a href="{{ route('register') }}">Créer une boutique</a>
                <a href="{{ route('login') }}">Connexion vendeur</a>
            </div>
            <div class="col-lg-4 mb-4">
                <h5>Contact</h5>
                <p class="small"><i class="fas fa-map-marker-alt me-2"></i>Bamako, Mali</p>
                <p class="small"><i class="fas fa-phone me-2"></i>+223 90 85 93 91</p>
                <p class="small"><i class="fas fa-envelope me-2"></i>contact@malimarket.ml</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="mb-0">© {{ date('Y') }} MaliMarket. Tous droits réservés. 🇲🇱 Fait avec ❤️ au Mali</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>