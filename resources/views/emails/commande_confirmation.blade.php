<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Commande - MaliMarket</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1a5276 0%, #2ecc71 100%); padding: 40px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; }
        .header p { color: rgba(255,255,255,0.8); margin: 10px 0 0; }
        .body { padding: 40px; }
        .greeting { font-size: 18px; color: #2c3e50; margin-bottom: 20px; }
        .order-number { background: #eef4ff; border-left: 4px solid #1a5276; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; }
        .order-number strong { color: #1a5276; font-size: 20px; }
        .section-title { font-size: 16px; font-weight: bold; color: #2c3e50; margin: 25px 0 15px; border-bottom: 2px solid #ecf0f1; padding-bottom: 8px; }
        .product-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #ecf0f1; }
        .product-name { color: #2c3e50; font-weight: 500; }
        .product-price { color: #1a5276; font-weight: bold; }
        .total-row { display: flex; justify-content: space-between; padding: 15px 0; font-size: 18px; font-weight: bold; color: #1a5276; border-top: 2px solid #1a5276; margin-top: 10px; }
        .info-box { background: #f8f9fa; border-radius: 10px; padding: 20px; margin: 20px 0; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { color: #7f8c8d; width: 140px; flex-shrink: 0; }
        .info-value { color: #2c3e50; font-weight: 500; }
        .badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .cta-button { display: block; background: linear-gradient(135deg, #1a5276, #2ecc71); color: white; text-decoration: none; text-align: center; padding: 15px 30px; border-radius: 25px; font-weight: bold; font-size: 16px; margin: 30px 0; }
        .footer { background: #1a252f; color: #bdc3c7; text-align: center; padding: 25px; font-size: 13px; }
        .footer a { color: #2ecc71; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1>MaliMarket 🇲🇱</h1>
            <p>Votre commande a été reçue avec succès !</p>
        </div>

        <!-- BODY -->
        <div class="body">
            <p class="greeting">Bonjour {{ $order->nom_livraison }} 👋</p>

            <p>Merci pour votre commande sur <strong>MaliMarket</strong> ! Nous avons bien reçu votre commande et elle est en cours de traitement.</p>

            <!-- NUMÉRO COMMANDE -->
            <div class="order-number">
                <div style="color: #7f8c8d; font-size: 13px; margin-bottom: 5px;">Numéro de commande</div>
                <strong>{{ $order->numero }}</strong>
            </div>

            <!-- PRODUITS -->
            <div class="section-title">📦 Produits commandés</div>
            @foreach($order->items as $item)
            <div class="product-item">
                <div>
                    <div class="product-name">{{ $item->product->nom ?? 'Produit' }}</div>
                    <div style="color: #7f8c8d; font-size: 13px;">Quantité : {{ $item->quantite }}</div>
                </div>
                <div class="product-price">{{ number_format($item->sous_total, 0, ',', ' ') }} FCFA</div>
            </div>
            @endforeach

            <!-- TOTAL -->
            <div class="total-row">
                <span>Total</span>
                <span>{{ number_format($order->montant_total, 0, ',', ' ') }} FCFA</span>
            </div>

            <!-- INFOS LIVRAISON -->
            <div class="section-title">🚚 Informations de livraison</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $order->nom_livraison }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">{{ $order->telephone_livraison }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse</span>
                    <span class="info-value">{{ $order->adresse_livraison }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ville</span>
                    <span class="info-value">{{ $order->ville_livraison }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paiement</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->mode_paiement)) }}</span>
                </div>
            </div>

            <!-- STATUT -->
            <div class="section-title">📊 Statut de la commande</div>
            <span class="badge badge-warning">⏳ En attente de confirmation</span>
            <p style="color: #7f8c8d; font-size: 13px; margin-top: 10px;">
                Nous vous contacterons au <strong>{{ $order->telephone_livraison }}</strong> pour confirmer votre commande et organiser la livraison.
            </p>

            <!-- CTA -->
            <a href="{{ url('/mes-commandes/' . $order->id) }}" class="cta-button">
                Suivre ma commande →
            </a>

            <p style="color: #7f8c8d; font-size: 13px; text-align: center;">
                Des questions ? Contactez-nous au <strong>+223 90 85 93 91</strong>
            </p>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>© {{ date('Y') }} MaliMarket 🇲🇱 — La Marketplace du Mali</p>
            <p><a href="{{ url('/') }}">www.malimarket.ml</a></p>
        </div>
    </div>
</body>
</html>