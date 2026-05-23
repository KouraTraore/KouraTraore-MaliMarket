@extends('layouts.app')

@section('title', 'Inscription - MaliMarket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <!-- LOGO -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold" style="color: #1a5276;">
                            Mali<span style="color: #2ecc71;">Market</span> 🇲🇱
                        </h2>
                        <p class="text-muted">Créez votre compte gratuitement</p>
                    </div>

                    <!-- ERREURS -->
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- FORMULAIRE -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- TYPE DE COMPTE -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Type de compte</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="radio" name="role" value="client" id="client" class="btn-check" checked>
                                    <label for="client" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                        <i class="fas fa-user fa-2x d-block mb-2"></i>
                                        Client
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="role" value="vendeur" id="vendeur" class="btn-check">
                                    <label for="vendeur" class="btn btn-outline-success w-100 py-3 rounded-3">
                                        <i class="fas fa-store fa-2x d-block mb-2"></i>
                                        Vendeur
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0"
                                    placeholder="Votre nom complet" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0"
                                    placeholder="votre@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" name="telephone" class="form-control border-start-0 ps-0"
                                    placeholder="+223 70 00 00 00" value="{{ old('telephone') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-mali w-100 py-3 fs-6">
                            <i class="fas fa-user-plus me-2"></i>Créer mon compte
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-0">Déjà un compte ?
                            <a href="{{ route('login') }}" class="fw-bold" style="color: #2ecc71;">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection