@extends('layouts.app')

@section('title', 'Commander - MaliMarket')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #1a5276;">
        <i class="fas fa-credit-card me-2" style="color: #2ecc71;"></i>
        Finaliser ma commande
    </h2>

    <div class="row g-4">
        <!-- FORMULAIRE -->
        <div class="col-lg-7">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf

                <!-- INFOS LIVRAISON -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-truck me-2" style="color: #2ecc71;"></i>
                            Informations de livraison
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nom complet</label>
                                <input type="text" name="nom_livraison" class="form-control rounded-3"
                                    value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Téléphone</label>
                                <input type="text" name="telephone_livraison" class="form-control rounded-3"
                                    value="{{ auth()->user()->telephone }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Adresse de livraison</label>
                                <input type="text" name="adresse_livraison" class="form-control rounded-3"
                                    placeholder="Ex: Quartier Badalabougou, près de la mosquée" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ville</label>
                                <select name="ville_livraison" class="form-select rounded-3">
                                    <option value="Bamako" selected>Bamako</option>
                                    <option value="Sikasso">Sikasso</option>
                                    <option value="Mopti">Mopti</option>
                                    <option value="Kayes">Kayes</option>
                                    <option value="Ségou">Ségou</option>
                                    <option value="Gao">Gao</option>
                                    <option value="Tombouctou">Tombouctou</option>
                                    <option value="Koulikoro">Koulikoro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Notes (optionnel)</label>
                                <textarea name="notes" class="form-control rounded-3" rows="2"
                                    placeholder="Instructions spéciales pour la livraison..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODE DE PAIEMENT -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-money-bill me-2" style="color: #2ecc71;"></i>
                            Mode de paiement
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="radio" name="mode_paiement" value="livraison" id="livraison" class="btn-check" checked>
                                <label for="livraison" class="btn btn-outline-secondary w-100 py-3 rounded-3">
                                    <i class="fas fa-truck fa-2x d-block mb-2"></i>
                                    Paiement à la livraison
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="mode_paiement" value="orange_money" id="orange_money" class="btn-check">
                                <label for="orange_money" class="btn btn-outline-warning w-100 py-3 rounded-3">
                                    <i class="fas fa-mobile-alt fa-2x d-block mb-2"></i>
                                    Orange Money
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="mode_paiement" value="moov_money" id="moov_money" class="btn-check">
                                <label for="moov_money" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                    <i class="fas fa-mobile-alt fa-2x d-block mb-2"></i>
                                    Moov Money
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-mali w-100 py-3 fs-5">
                    <i class="fas fa-check-circle me-2"></i>Confirmer ma commande
                </button>
            </form>
        </div>

        <!-- RESUME COMMANDE -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Récapitulatif</h5>

                    @php $total = 0; @endphp
                    @foreach(session('cart', []) as $id => $item)
                    @php $total += $item['prix'] * $item['quantite']; @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($item['image'])
                            <img src="{{ asset($item['image']) }}" class="rounded-3" style="width:55px;height:55px;object-fit:cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:55px;height:55px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small">{{ $item['nom'] }}</p>
                            <small class="text-muted">Qté: {{ $item['quantite'] }}</small>
                        </div>
                        <span class="fw-bold small">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total</span>
                        <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Livraison</span>
                        <span class="text-success fw-bold">Gratuite</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5" style="color: #1a5276;">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection