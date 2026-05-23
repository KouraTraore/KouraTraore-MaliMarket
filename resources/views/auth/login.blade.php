@extends('layouts.app')

@section('title', 'Connexion - MaliMarket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <!-- LOGO -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold" style="color: #1a5276;">
                            Mali<span style="color: #2ecc71;">Market</span> 🇲🇱
                        </h2>
                        <p class="text-muted">Connectez-vous à votre compte</p>
                    </div>

                    <!-- ERREURS -->
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- FORMULAIRE -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-600">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0"
                                    placeholder="votre@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-600">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-mali w-100 py-3 fs-6">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-0">Pas encore de compte ?
                            <a href="{{ route('register') }}" class="fw-bold" style="color: #2ecc71;">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection